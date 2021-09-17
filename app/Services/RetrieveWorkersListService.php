<?php

namespace App\Services;

use App\Models\WorkerHasBeacon;
use App\Models\WorkerHasDepartment;

class RetrieveWorkersListService
{
    public function RetrieveWorkersList()
    {
        $workers_list = [];

        // $workers = WorkerHasBeacon::leftjoin('workers', 'worker_has_beacons.worker_tbl_id', '=', 'workers.worker_tbl_id')
        //     ->leftjoin('beacons', 'worker_has_beacons.beacon_tbl_id', '=', 'beacons.beacon_tbl_id')
        //     ->where('worker_has_beacons.date_unassigned', '=', NULL)
        //     ->select('workers.*', 'beacons.beacon_id')
        //     ->get();
        
        //Justin Requested the logic be changed from retrieving all workers with beacons to retrieving all workers in the demoulded department
        $workers = WorkerHasDepartment::leftjoin('workers', 'worker_has_department.worker_tbl_id', '=', 'workers.worker_tbl_id')
        ->leftjoin('departments', 'worker_has_department.dprt_tbl_id', '=', 'departments.dprt_tbl_id')
        ->where('departments.dprt_name', '=', "Mould Maker")
        ->where('workers.status', '=', 1)
        ->select('workers.*', 'departments.dprt_name')
        ->get();

        foreach ($workers as $worker) {
            $workers_list[$worker->worker_tbl_id] = $worker->worker_id;
        }

        return $workers_list;
    }
}
