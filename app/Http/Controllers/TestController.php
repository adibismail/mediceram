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

        $daily_total_formers = ElectronicProductCode::leftjoin('formers', 'electronic_product_codes.epc_tbl_id', '=', 'formers.epc_tbl_id')
                ->whereDate('formers.created_at', '=', Carbon::today())
                ->count();

        $daily_total_passed = ElectronicProductCode::leftjoin('formers', 'electronic_product_codes.epc_tbl_id', '=', 'formers.epc_tbl_id')
            ->leftjoin('quality_check_codes', 'formers.qc_code_tbl_id', '=', 'quality_check_codes.qc_code_tbl_id')
            ->whereDate('formers.created_at', '=', Carbon::today())
            ->where('quality_check_codes.qc_code', '=', '0') // 0 = passed former
            ->count();

        $daily_total_failed = $daily_total_formers - $daily_total_passed;

        return response()->json([
            "dtf" => $daily_total_formers,
            "dtp" => $daily_total_passed,
            "dtfa" => $daily_total_failed,
        ], 200);
    }
}
