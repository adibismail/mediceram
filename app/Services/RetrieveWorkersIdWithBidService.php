<?php

namespace App\Services;

use App\Models\Beacon;
use App\Models\WorkerHasBeacon;

class RetrieveWorkersIdWithBidService
{
    public function RetrieveWorkersIdWithBid($bid)
    {
        $workers_id_arr = [];
        $bids = json_decode($bid);
        foreach ($bids as $bid) {
            $beacon = Beacon::firstWhere('beacon_id', $bid);

            $worker_id = WorkerHasBeacon::leftjoin('workers', 'worker_has_beacons.worker_tbl_id', '=', 'workers.worker_tbl_id')
                ->leftjoin('beacons', 'worker_has_beacons.beacon_tbl_id', '=', 'beacons.beacon_tbl_id')
                ->where('worker_has_beacons.beacon_tbl_id', '=', $beacon->beacon_tbl_id ?? "")
                ->where('worker_has_beacons.date_unassigned', '=', NULL)
                ->select('workers.worker_id')
                ->first();

            $workers_id_arr[$bid] = $worker_id->worker_id ?? "";
        }

        return $workers_id_arr;
    }
}
