<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ElectronicProductCode;
use App\Models\PlasterMould;
use App\Models\Former;
use App\Models\Order;
use App\Models\Customer;
use App\Models\QualityCheckCode;
use Illuminate\Support\Carbon;
class TestController extends Controller
{
    //
    public function index() {
        // $date_start = "2021-01-01";
        // $date_end = "2021-09-06";
        // $plaster_moulds = PlasterMould::with('epc', 'model', 'epc.pms', 'epc.worker')
        //                 ->whereBetween('created_at', [$date_start, $date_end])->get();
        // $epcs = $plaster_moulds->pluck('epc_tbl_id');
        // $formers = Former::whereIn('epc_tbl_id', $epcs)->get()->groupBy('epc_tbl_id');
        // $qc_codes = QualityCheckCode::get()->groupBy('qc_code_tbl_id');
        // $isConsecutive = true;
        // $numberValue = 0;
        // $failure_array = []; //Array of EPC Table IDs that meet the failure rate
        // $failure_objects = [];
        // foreach ($formers as $epc => $former_array){
        //     $consecutive_count = 0;
        //     $highest_consecutive_count = 0;
        //     $failure_count = 0;
        //     foreach ($former_array as $former){
        //         if ($qc_codes[$former->qc_code_tbl_id][0]->qc_code != 0){
        //             $failure_count++;
        //             $consecutive_count++;
        //         }else{
        //             if ($consecutive_count > $highest_consecutive_count){
        //                 $highest_consecutive_count = $consecutive_count;
        //             }
        //             $consecutive_count = 0;
        //         }
        //     }
        //     if ($consecutive_count > $highest_consecutive_count){
        //         $highest_consecutive_count = $consecutive_count;
        //     }
        //     if (!$isConsecutive){
        //         $total_count = count($former_array);
        //         $failure_percentage = $failure_count/$total_count*100;
        //         if ($failure_percentage >= $numberValue){
        //             array_push($failure_array, $former->epc_tbl_id);
        //             $failure_object = (object)[];
        //             $failure_object->epc = $former->epc_tbl_id;
        //             $failure_object->consecutive = $highest_consecutive_count;
        //             $failure_object->rejection_ratio = $failure_percentage;
        //             $failure_objects[$former->epc_tbl_id] = $failure_object;
        //         }
        //     }else{
        //         $total_count = count($former_array);
        //         $failure_percentage = $failure_count/$total_count*100;
        //         if ($highest_consecutive_count >= $numberValue){
        //             array_push($failure_array, $former->epc_tbl_id);
        //             $failure_object = (object)[];
        //             $failure_object->epc = $former->epc_tbl_id;
        //             $failure_object->consecutive = $highest_consecutive_count;
        //             $failure_object->rejection_ratio = $failure_percentage;
        //             $failure_objects[$former->epc_tbl_id] = $failure_object;
        //         }
        //     }
        // }
        // $reject_moulds = $plaster_moulds->whereIn('epc_tbl_id', 5);
        // $formers = Former::whereIn('epc_tbl_id', $failure_array)->orderBy('created_at')->get()->groupBy('epc_tbl_id');
        // foreach ($reject_moulds as $mould){
        //     $mould->latest_former = ($formers[$mould->epc->epc_tbl_id])->last()->created_at;
        //     $mould->rejection_ratio = $failure_objects[$mould->epc->epc_tbl_id]->rejection_ratio;
        //     $mould->consecutive = $failure_objects[$mould->epc->epc_tbl_id]->consecutive;
        // }

        // return json_encode($reject_moulds);
        // if (is_object($reject_moulds)){
        //     $array = [];
        //     foreach ($reject_moulds as $key => $value){
        //         array_push($array, $value);
        //     }
        //     return response()->json([
        //         "moulds" => $array,
        //     ], 200);
        // }
        // return response()->json([
        //     "moulds" => $reject_moulds,
        // ], 200);

        // $date_start = Carbon::now()->subMonths(6);
        // $date_end = Carbon::now();
        // $plaster_moulds = PlasterMould::with('epc')->whereBetween('created_at', [$date_start, $date_end])->get();
        // foreach ($plaster_moulds as $pm){
        //     $pm->epc_title = $pm->epc->epc;
        // }
        // $orders = Order::with('mould_model')->get();//->groupBy('customer_tbl_id');
        // $customers = Customer::get();

        // foreach ($orders as $order){
        //     $order->mould_description = $order->mould_model->description;
        //     $order->mould_id = $order->mould_model->mould_mdl_id;
        // }
        // $orders = $orders->groupBy('customer_tbl_id');

        // return Inertia::render('OrdersMonitor/rejection-table', [
        //     'moulds' => $plaster_moulds,
        //     'customers' => $customers,
        //     'orders' => $orders,
        // ]);
        $plaster_moulds = PlasterMould::leftjoin('electronic_product_codes', 'plaster_moulds.epc_tbl_id', '=', 'electronic_product_codes.epc_tbl_id')
		->leftjoin('worker_has_epcs', 'electronic_product_codes.epc_tbl_id', '=', 'worker_has_epcs.epc_tbl_id')
		->leftjoin('workers', 'worker_has_epcs.worker_tbl_id', '=', 'workers.worker_tbl_id')
		->leftjoin('plaster_moulding_stations', 'electronic_product_codes.pms_tbl_id', '=', 'plaster_moulding_stations.pms_tbl_id')
		->leftjoin('mould_models', 'plaster_moulds.mould_mdl_tbl_id', '=', 'mould_models.mould_mdl_tbl_id')
		->get();

        $total_moulds = PlasterMould::get()
        ->count();

        $daily_total_formers = ElectronicProductCode::leftjoin('formers', 'electronic_product_codes.epc_tbl_id', '=', 'formers.epc_tbl_id')
                ->where('electronic_product_codes.created_at', '=', '2021-01-15')
                ->count();

        $daily_total_passed = ElectronicProductCode::leftjoin('formers', 'electronic_product_codes.epc_tbl_id', '=', 'formers.epc_tbl_id')
            ->leftjoin('quality_check_codes', 'formers.qc_code_tbl_id', '=', 'quality_check_codes.qc_code_tbl_id')
            ->where('electronic_product_codes.created_at', '=', '2021-01-15')
            ->where('quality_check_codes.qc_code', '=', '0') // 0 = passed former
            ->count();

        $daily_total_failed = $daily_total_formers - $daily_total_passed;

        $recent_fails = Former::where('created_at', '>=', Carbon::today()->subDays(7))
        ->with('epc', 'epc.plaster', 'qc')
        ->whereHas('qc', function ($query) {
            return $query->where('qc_code', '!=', 0);
        })->get();

        if (!count($recent_fails))
            $recent_fails = ["Empty"];

        $orders = Order::with('mould_model')->get();//->groupBy('customer_tbl_id');
        $customers = Customer::get();

        foreach ($orders as $order){
            $order->mould_description = $order->mould_model->description;
        }
        $orders = $orders->groupBy('customer_tbl_id');

        $date_start = Carbon::now()->subMonths(6);
        $date_end = Carbon::now();
        $moulds = PlasterMould::with('epc')->whereBetween('created_at', [$date_start, $date_end])->get();
        foreach ($moulds as $pm){
            $pm->epc_title = $pm->epc->epc;
        }
        return Inertia::render('Orders/test', [
            'plaster_moulds' => $plaster_moulds,
            'daily_total_formers' => $daily_total_formers,
            'total_moulds' => $total_moulds,
            'daily_total_failed' => $daily_total_failed,
            'daily_total_passed' => $daily_total_passed,
            'recent_fails' => $recent_fails,
            'customers' => $customers,
            'orders' => $orders,
            'moulds' => $moulds,
        ]);

    }
}
