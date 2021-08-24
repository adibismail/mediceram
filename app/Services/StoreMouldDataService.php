<?php

namespace App\Services;

use App\Models\Worker;
use App\Models\PlasterMould;
use App\Models\WorkerHasEpc;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ElectronicProductCode;
use App\Models\PlasterMouldingStation;
use App\Models\PlasterMouldingStationAttendance;

class StoreMouldDataService
{
    public function StoreMouldData($epc, $tid, $worker_id, $mould_id, $mould_creation_date, $plaster_moulding_station_id)
    {
        $date = date_create($mould_creation_date);
        $date = date_format($date, "Y-m-d");

        DB::beginTransaction();
        try {
            $plaster_moulding_station = PlasterMouldingStation::firstWhere('plaster_moulding_station_id', $plaster_moulding_station_id);

            $tid_exists_same_date = ElectronicProductCode::where('tid', '=', $tid)->whereDate('created_at', '=', $date)->first();
            
            // if not found same tid on same date, insert new
            if ($tid_exists_same_date === null) {
                $epc_tbl = new ElectronicProductCode;
                $epc_tbl->epc = strtoupper($epc);
                $epc_tbl->tid = $tid;
                $epc_tbl->created_at = $date;
                $epc_tbl->last_used = $date;
                $epc_tbl->pms_tbl_id = $plaster_moulding_station->pms_tbl_id;
                $epc_tbl->save();
            } else { // if found, delete and insert latest
                PlasterMould::where('epc_tbl_id', $tid_exists_same_date->epc_tbl_id)->delete();
                WorkerHasEpc::where('epc_tbl_id', $tid_exists_same_date->epc_tbl_id)->delete();
                ElectronicProductCode::where('epc_tbl_id', $tid_exists_same_date->epc_tbl_id)->delete();

                $epc_tbl = new ElectronicProductCode;
                $epc_tbl->epc = strtoupper($epc);
                $epc_tbl->tid = $tid;
                $epc_tbl->created_at = $date;
                $epc_tbl->last_used = $date;
                $epc_tbl->pms_tbl_id = $plaster_moulding_station->pms_tbl_id;
                $epc_tbl->save();
            }

            $plaster_mould_tbl = new PlasterMould;
            $plaster_mould_tbl->epc_tbl_id = $epc_tbl->epc_tbl_id;
            $plaster_mould_tbl->created_at = $mould_creation_date;
            $plaster_mould_tbl->mould_mdl_tbl_id = $mould_id;
            $plaster_mould_tbl->save();

            $worker_has_epc_tbl = new WorkerHasEpc;
            $worker_has_epc_tbl->epc_tbl_id = $epc_tbl->epc_tbl_id;
            $worker_has_epc_tbl->worker_tbl_id = $worker_id;
            $worker_has_epc_tbl->save();
            
            $worker = Worker::firstWhere('worker_tbl_id', $worker_id);
            $plaster_moulding_station_attendance = new PlasterMouldingStationAttendance();
            $plaster_moulding_station_attendance->datetime =  $mould_creation_date;
            $plaster_moulding_station_attendance->worker_tbl_id = $worker->worker_tbl_id;
            $plaster_moulding_station_attendance->pms_tbl_id =  $plaster_moulding_station->pms_tbl_id;
            $plaster_moulding_station_attendance->save();

            DB::commit();

            $msg = "Data validated and stored.";
            return $msg;
        } catch (\Exception $e) {
            DB::rollback();
            $msg = "Error. Check with system admin.";
            Log::channel('post_mould_data_logger')->info($e);

            return $msg;
        }
    }
}
