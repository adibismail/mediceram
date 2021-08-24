<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\ElectronicProductCode;

class GenerateNewEpcService
{
    public function GenerateNewEpc()
    {
        $date_now = date("Y-m-d");
        $db_return_rows = ElectronicProductCode::where('created_at', $date_now)->get()->count();
        $last_epc = ElectronicProductCode::latest('epc_tbl_id')->first();
        Log::channel('get_new_epc_logger')->info($last_epc);

        if ($db_return_rows == 0) {
            // if zero data return from db today, then starts with 01
            $comp_id = "4D"; // fixed
            $proj_id = "00"; // fixed
            $date = date("Ymd");
            $station_id = "00"; // not in use
            $station_type = "00"; // not in use
            $res_1 = "00"; // reserved
            $res_2 = "00"; // reserved
            $increment = "0000"; // starts from 0000
            $epc = $comp_id . $proj_id . $date . $station_id . $station_type . $res_1 . $res_2 . $increment;

            return $epc;
        } else {
            // else, get the last row's epc, substr it, and +1
            $last_epc = $last_epc->epc;

            $comp_id = substr($last_epc, 0, 2);
            $proj_id = substr($last_epc, 2, 2);
            $date = substr($last_epc, 4, 8);
            $station_id = substr($last_epc, 12, 2);
            $station_type = substr($last_epc, 14, 2);
            $res_1 = substr($last_epc, 16, 2); // reserved
            $res_2 = substr($last_epc, 18, 2); // reserved
            $increment = substr($last_epc, 20) + 1; // id increment by 1
            $increment = str_pad($increment, 4, "0", STR_PAD_LEFT); // add leading zeros
            $epc = $comp_id . $proj_id . $date . $station_id . $station_type . $res_1 . $res_2 . $increment;

            return $epc;
        }
    }
}
