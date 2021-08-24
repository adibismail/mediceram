<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\GenerateNewEpcService;
use App\Services\RetrieveWorkersListService;
use App\Services\RetrieveMouldModelsListService;
use App\Services\RetrieveMouldDataService;
use App\Services\CalculateMouldRejectionRatioService;
use App\Services\RetrieveWorkersIdWithBidService;
use App\Services\StoreFormerDataService;
use App\Services\StoreMouldDataService;

class ApiController extends Controller
{
    public function get_new_epc(GenerateNewEpcService $generate_new_epc_service)
    {
        $new_epc = $generate_new_epc_service->GenerateNewEpc();

        return Response::json(array(
            'epc' => $new_epc,
        ));
    }

    public function get_mould_reg_data(RetrieveWorkersListService $retrieve_workers_list_service, RetrieveMouldModelsListService $retrieve_mould_models_list_service)
    {
        $workers_list = $retrieve_workers_list_service->RetrieveWorkersList();
        $mould_models_list = $retrieve_mould_models_list_service->RetrieveMouldModelsList();

        return Response::json(array(
            'workers_list' => $workers_list,
            'mould_models_list' => $mould_models_list
        ));
    }

    public function post_mould_data(Request $request, StoreMouldDataService $store_mould_data_service)
    {
        Log::channel('post_mould_data_logger')->info($request->all());

        // $epc = $request->epc;
        // $tid = substr($request->tid, 8, 16);
        // $worker_id = $request->worker_id;
        // $mould_id = $request->mould_model;
        // $mould_creation_date = $request->mould_creation_date;
        // $plaster_moulding_station_id = $request->plaster_moulding_station_id;
        // $size_of_received_data = sizeof($request->all());

        // if (isset($epc) && isset($tid) && isset($worker_id) && isset($mould_id) && isset($mould_creation_date) && isset($plaster_moulding_station_id) && $size_of_received_data == 6) {
        //     $store_mould_data_msg = $store_mould_data_service->StoreMouldData($epc, $tid, $worker_id, $mould_id, $mould_creation_date, $plaster_moulding_station_id);

        //     return response()->json(["message" => $store_mould_data_msg, "body" => $request->all()], 200);
        // } else {
        //     $msg = "Some keys are missing OR extra key(s) found. Please check the data in the body.";

        //     return response()->json(["err_msg" => $msg, "body" => $request->all()], 406);
        // }
    }

    public function get_workers_data(Request $request, RetrieveWorkersIdWithBidService $retrieve_workers_id_with_bid_service)
    {
        Log::channel('get_worker_data_logger')->info($request->all());
        $bid = $request->bid;

        // validate if epc & casting_station_id are in the GET parameters
        if ($bid) {
            $workers_id_list = $retrieve_workers_id_with_bid_service->RetrieveWorkersIdWithBid($bid);

            return Response::json(array(
                'workers_id_list' => $workers_id_list,
            ));
        } else {
            Log::channel('get_worker_data_logger')->info($request->all());
            return response()->json(["err_msg" => "Parameter not exist."], 406);
        }
    }

    public function get_mould_data(Request $request, RetrieveMouldDataService $retrieve_mould_data_service, CalculateMouldRejectionRatioService $calculate_mould_rejection_ratio_service)
    {
        Log::channel('get_mould_data_logger')->info($request->all());
        $epc = $request->epc;
        $casting_station_id = $request->casting_station_id;

        // validate if epc & casting_station_id are in the GET parameters
        if ($epc && $casting_station_id) {
            $mould_data = $retrieve_mould_data_service->RetrieveMouldData($epc, $casting_station_id);
            $mould_rejection_ratio = $calculate_mould_rejection_ratio_service->CalculateMouldRejectionRatio($epc);

            if (!is_null($mould_data)) {
                return Response::json(array(
                    'plaster_moulding_station_id' => $mould_data->plaster_moulding_station_id ?? "",
                    'mould_rejection_ratio' => $mould_rejection_ratio ?? "",
                    'mould_id' => $mould_data->mould_mdl_id ?? "",
                    'former_optimum_weight_min' => number_format($mould_data->fmr_opt_wgt_min ?? 0, 2, '.', ''),
                    'former_optimum_weight_max' => number_format($mould_data->fmr_opt_wgt_max ?? 0, 2, '.', ''),
                    'remaining_qty' => $mould_data->order_qty - $mould_data->done_qty,
                ));
            } else {
                return response()->json(["err_msg" => "EPC/Casting Station ID not exists OR order not found."], 406);
            }
             
        } else {
            Log::channel('get_mould_data_logger')->info($request->all());

            return response()->json(["err_msg" => "Parameter(s) missing/not exist."], 406);
        }
    }

    public function post_former_data(Request $request, StoreFormerDataService $store_former_data_service)
    {
        Log::channel('post_former_data_logger')->info($request->all());

        $epc = $request->epc;
        $bid = $request->bid;
        $former_weight = $request->former_weight;
        $date_time = $request->date_time;
        $failure_code = $request->failure_code;
        $casting_station_id = $request->casting_station_id;
        $size_of_received_data = sizeof($request->all());

        if (isset($epc) && isset($bid) && isset($former_weight) && isset($date_time) && isset($failure_code) && isset($casting_station_id) && $size_of_received_data == 6) {
            $store_former_data_msg = $store_former_data_service->StoreFormerData($epc, $bid, $former_weight, $date_time, $failure_code, $casting_station_id);

            if ($store_former_data_msg[0] == "msg") {
                return response()->json(["message" => $store_former_data_msg[1], "body" => $request->all()], 200);
            } else if ($store_former_data_msg[0] == "err_msg") {
                return response()->json(["err_msg" => $store_former_data_msg[1], "body" => $request->all()], 406);
            }
        } else {
            $msg = "Some keys are missing OR extra key(s) found. Please check the data in the body.";

            return response()->json(["err_msg" => $msg, "body" => $request->all()], 406);
        }
    }
}
