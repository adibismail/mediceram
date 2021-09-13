<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ElectronicProductCode;
use App\Models\PlasterMould;
use App\Models\Former;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Carbon;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
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
        return Inertia::render('Dashboard/Carousel-Index', [
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
	
	public function get_formers($idget) {
		$id = $idget;
		
		$formers = Former::
		get();
		
		return response()->json(["formers" => $formers], 200);
    }
}
