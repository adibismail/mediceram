<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Beacon;
use App\Models\Department;
use App\Models\Worker;
use Illuminate\Http\Request;
use App\Models\WorkerHasBeacon;
use App\Models\WorkerHasDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class WorkersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $active_workers = 
            Worker::leftJoin('worker_has_beacons', function($join)
                {
                $join->on('workers.worker_tbl_id', '=', 'worker_has_beacons.worker_tbl_id')
                    ->whereNull('worker_has_beacons.date_unassigned')
                    ->orderBy('worker_has_beacons.id', 'desc')
                    ->limit(1);
                })
            ->leftjoin('beacons', 'worker_has_beacons.beacon_tbl_id', '=', 'beacons.beacon_tbl_id')
            ->leftjoin('worker_has_department', 'workers.worker_tbl_id', '=', 'worker_has_department.worker_tbl_id')
            ->leftjoin('departments', 'worker_has_department.dprt_tbl_id', '=', 'departments.dprt_tbl_id')
            ->where('workers.status', '1')
            ->select('workers.*', 'beacons.beacon_id', 'worker_has_beacons.beacon_tbl_id', 'departments.*')
            ->get();

        $inactive_workers = 
            Worker::leftJoin('worker_has_beacons', function($join)
                {
                $join->on('workers.worker_tbl_id', '=', 'worker_has_beacons.worker_tbl_id')
                    ->whereNull('worker_has_beacons.date_unassigned')
                    ->orderBy('worker_has_beacons.id', 'desc')
                    ->limit(1);
                })
            ->leftjoin('beacons', 'worker_has_beacons.beacon_tbl_id', '=', 'beacons.beacon_tbl_id')
            ->leftjoin('worker_has_department', 'workers.worker_tbl_id', '=', 'worker_has_department.worker_tbl_id')
            ->leftjoin('departments', 'worker_has_department.dprt_tbl_id', '=', 'departments.dprt_tbl_id')
            ->where('workers.status', '0')
            ->select('workers.*', 'beacons.beacon_id', 'worker_has_beacons.beacon_tbl_id', 'departments.*')
            ->get();
        
        // beacon status 1 = in use, 0 = not in use
        $beacons = Beacon::where('status', '=', '0')->get();

        $departments = Department::get();
        
        return Inertia::render('Workers/Index', [
            'active_workers' => $active_workers,
            'inactive_workers' => $inactive_workers,
            'beacons' => $beacons,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request, Worker $worker) {
        //Log::channel('post_workers_data_logger')->info($request);
        
        // if assigning beacon when adding new worker
        if (!is_null($request->beacon_id)) {
            $this->validate($request, [
                'worker_id' => ['required', 'unique:workers,worker_id', 'max:50'],
                'worker_name' => ['required', 'unique:workers,worker_name', 'max:50'],
                'dprt_tbl_id' => ['required'],
            ]);

            DB::beginTransaction();
            try {
                $new_worker = new Worker;
                $new_worker->worker_id = $request->worker_id;
                $new_worker->worker_name = $request->worker_name;
                $new_worker->save();

                $worker_has_department = new WorkerHasDepartment;
                $worker_has_department->worker_tbl_id = $new_worker->worker_tbl_id;
                $worker_has_department->dprt_tbl_id = $request->dprt_tbl_id;
                $worker_has_department->save();

                $beacon = Beacon::firstWhere('beacon_id', $request->beacon_id);

                $worker_has_beacon = new WorkerHasBeacon;
                $worker_has_beacon->worker_tbl_id = $new_worker->worker_tbl_id;
                $worker_has_beacon->beacon_tbl_id = $beacon->beacon_tbl_id;
                $worker_has_beacon->date_assigned = Carbon::now();
                $worker_has_beacon->save();

                Beacon::where('beacon_tbl_id', $beacon->beacon_tbl_id)
                    ->update(['status' => 1]);
                
                DB::commit();

                return Redirect::route('workers')->with('success_msg', 'Worker created.');
            } catch (\Exception $e) {
                DB::rollback();
                //Log::channel('post_workers_data_logger')->info($e);
            }
        // if not assigning beacon, then just add new worker
        } else if (is_null($request->beacon_id)) {
            $this->validate($request, [
                'worker_id' => ['required', 'unique:workers,worker_id', 'max:50'],
                'worker_name' => ['required', 'unique:workers,worker_name', 'max:50'],
                'dprt_tbl_id' => ['required'],
            ]);

            DB::beginTransaction();
            try {
                $new_worker = new Worker;
                $new_worker->worker_id = $request->worker_id;
                $new_worker->worker_name = $request->worker_name;
                $new_worker->save();

                $worker_has_department = new WorkerHasDepartment;
                $worker_has_department->worker_tbl_id = $new_worker->worker_tbl_id;
                $worker_has_department->dprt_tbl_id = $request->dprt_tbl_id;
                $worker_has_department->save();

                DB::commit();

                return Redirect::route('workers')->with('success_msg', 'Worker created.');
            } catch (\Exception $e) {
                DB::rollback();
                //Log::channel('post_workers_data_logger')->info($e);
            }
        }
    }

    public function update(Request $request) {
        Log::channel('post_workers_data_logger')->info($request->all());

        // beacon status 1 = in use, 0 = not in use

        // worker ALREADY ASSIGNED with beacon, and admin wants to UNASSIGN from the worker
        // if beacon_id NOT NULL && new_beacon_id NULL
        if (!is_null($request->beacon_id) && is_null($request->new_beacon_id)) {
            WorkerHasBeacon::where('beacon_tbl_id', $request->beacon_tbl_id)
                ->where('worker_tbl_id', $request->worker_tbl_id)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->update(['date_unassigned' => Carbon::now()]);

            Beacon::where('beacon_tbl_id', $request->beacon_tbl_id)
                ->update(['status' => 0]);
        }

        // worker ALREADY ASSIGNED with beacon, and admin wants to ASSIGN ANOTHER beacon to the worker
        // beacon_id NOT NULL && new_beacon_id NOT NULL
        else if (!is_null($request->beacon_id) && !is_null($request->new_beacon_id)) {
            // unassign beacon from the worker
            WorkerHasBeacon::where('beacon_tbl_id', $request->beacon_tbl_id)
                ->where('beacon_tbl_id', $request->beacon_tbl_id)
                ->where('worker_tbl_id', $request->worker_tbl_id)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->update(['date_unassigned' => Carbon::now()]);
            
            // update previous assigned beacon's status to 0 not in use
            Beacon::where('beacon_tbl_id', $request->beacon_tbl_id)
            ->update(['status' => 0]);
            
            // assign new beacon to the worker
            $new_beacon = Beacon::firstWhere('beacon_id', $request->new_beacon_id);

            WorkerHasBeacon::insert([
                'worker_tbl_id' => $request->worker_tbl_id,
                'beacon_tbl_id' => $new_beacon->beacon_tbl_id,
                'date_assigned' => Carbon::now(),
            ]);

            // update new assigned beacon's status to 1 in use
            Beacon::where('beacon_tbl_id', $new_beacon->beacon_tbl_id)
                ->update(['status' => 1]);
        }

        // worker is NOT ASSIGNED with any beacon, and admin wants to ASSIGN a beacon to the worker
        // beacon_id NULL && new_beacon_id NOT NULL
        else if (is_null($request->beacon_id) && !is_null($request->new_beacon_id)) {
            $new_beacon = Beacon::firstWhere('beacon_id', $request->new_beacon_id);

            WorkerHasBeacon::insert([
                'worker_tbl_id' => $request->worker_tbl_id,
                'beacon_tbl_id' => $new_beacon->beacon_tbl_id,
                'date_assigned' => Carbon::now(),
            ]);

            Beacon::where('beacon_tbl_id', $new_beacon->beacon_tbl_id)
                ->update(['status' => 1]);
        }

        return Redirect::route('workers')->with('success_msg', 'Worker updated.');
    }

    public function delete(Request $request) {
        //Log::channel('post_workers_data_logger')->info($request->all());

        Worker::where('worker_tbl_id', $request->worker_tbl_id)
            ->update(['status' => 0]);

        WorkerHasBeacon::where('beacon_tbl_id', $request->beacon_tbl_id)
            ->where('beacon_tbl_id', $request->beacon_tbl_id)
            ->where('worker_tbl_id', $request->worker_tbl_id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->update(['date_unassigned' => Carbon::now()]);

        Beacon::where('beacon_tbl_id', $request->beacon_tbl_id)
            ->update(['status' => 0]);

        return Redirect::route('workers')->with('success_msg', 'Worker deactivated.');
    }

    public function get_avail_beacons() {
        $avail_beacons = Beacon::where('status', '=', '0')->get();

        return response()->json(["avail_beacons" => $avail_beacons], 200);
    }
}
