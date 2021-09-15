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

        $qc_code = QualityCheckCode::firstWhere('qc_code', 60); 

        if ($qc_code === null)
            return "null";
       
        $id = 1;
        $export = Order::leftjoin('order_has_formers', 'orders.order_tbl_id', '=', 'order_has_formers.order_tbl_id')
            ->leftjoin('formers', 'order_has_formers.former_tbl_id', '=', 'formers.former_tbl_id')
            ->selectRaw('formers.created_at, formers.former_weight, orders.fmr_opt_wgt_min, orders.fmr_opt_wgt_max')
            ->where('orders.order_tbl_id', $id)
            ->where('formers.qc_code_tbl_id', '1')
            ->get();
        // $export = Order::with('formers')
        // ->where('order_tbl_id', $id)
        // ->whereHas('formers.qc', function ($query) {
        //     return $query->where('qc_code', '=', 0);})
        // ->get();

        return $export;
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
