<?php

namespace App\Services;

use App\Models\WorkerHasBeacon;

class RetrieveWorkersListService
{
    public function RetrieveWorkersList()
    {
        $workers_list = [];

        $workers = WorkerHasBeacon::leftjoin('workers', 'worker_has_beacons.worker_tbl_id', '=', 'workers.worker_tbl_id')
            ->leftjoin('beacons', 'worker_has_beacons.beacon_tbl_id', '=', 'beacons.beacon_tbl_id')
            ->where('worker_has_beacons.date_unassigned', '=', NULL)
            ->select('workers.*', 'beacons.beacon_id')
            ->get();

        foreach ($workers as $worker) {
            $workers_list[$worker->worker_tbl_id] = $worker->worker_id;
        }

        return $workers_list;
    }
}
