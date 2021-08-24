<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Beacon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class BeaconsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $beacons = Beacon::get();
        
        return Inertia::render('Beacons/Index', [
            'beacons' => $beacons,
        ]);
    }

    public function store(Request $request, Beacon $beacon) {
        //Log::channel('post_beacons_data_logger')->info($request->all());
        
        $beacon->create(
            $this->validate($request, [
                'beacon_id' => ['required', 'unique:beacons,beacon_id', 'max:12'],
            ])
        );

        return Redirect::route('beacons')->with('success_msg', 'Beacon created.');
    }

    public function update(Request $request) {
        //Log::channel('post_beacons_data_logger')->info($request->all());

        $beacon = Beacon::find($request->beacon_tbl_id);
        
        $beacon->update(
            $this->validate($request, [
                'beacon_id' => ['required', 'unique:beacons,beacon_id,' . $request->beacon_tbl_id . ',beacon_tbl_id', 'max:12'],
            ])
        );

        return Redirect::route('beacons')->with('success_msg', 'Beacon updated.');
    }

    public function delete(Request $request) {
        //Log::channel('post_beacons_data_logger')->info($request->all());

        try {
            Beacon::destroy($request->beacon_tbl_id);
            return redirect()->back()->with('success_msg', 'Beacon deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_msg', 'Beacon could not be deleted as it there is history found assigning to a worker.');
        }
    }
}
