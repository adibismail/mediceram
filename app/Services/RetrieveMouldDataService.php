<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\ElectronicProductCode;

class RetrieveMouldDataService
{
    public function RetrieveMouldData($epc, $casting_station_id)
    {
        $mould_data = ElectronicProductCode::leftjoin('plaster_moulds', 'electronic_product_codes.epc_tbl_id', '=', 'plaster_moulds.epc_tbl_id')
            ->leftjoin('mould_models', 'plaster_moulds.mould_mdl_tbl_id', '=', 'mould_models.mould_mdl_tbl_id')
            ->leftjoin('orders', 'mould_models.mould_mdl_tbl_id', '=', 'orders.mould_mdl_tbl_id')
            ->leftjoin('plaster_moulding_stations', 'electronic_product_codes.pms_tbl_id', '=', 'plaster_moulding_stations.pms_tbl_id')
            ->leftjoin('casting_stations', 'orders.cs_tbl_id', '=', 'casting_stations.cs_tbl_id')
            ->where('electronic_product_codes.epc', $epc)
            ->where('casting_stations.casting_station_id', $casting_station_id)
            ->where('orders.prod_date', '<=', Carbon::today())
            ->where('orders.status', '1')
            ->whereRaw('orders.done_qty < orders.order_qty')
            ->select('mould_models.mould_mdl_id', 'plaster_moulding_stations.plaster_moulding_station_id', 'orders.*')
            ->first();
        
        return $mould_data;
    }
}
