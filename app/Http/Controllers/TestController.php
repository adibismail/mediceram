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

        $epc = "4D0020210923000000000006";
            // get total number of formers
            $epc_total_formers = ElectronicProductCode::leftjoin('formers', 'electronic_product_codes.epc_tbl_id', '=', 'formers.epc_tbl_id')
            ->where('electronic_product_codes.epc', '=', $epc)
            ->count();
   
           // get total number of formers passed
           $epc_total_passed = ElectronicProductCode::leftjoin('formers', 'electronic_product_codes.epc_tbl_id', '=', 'formers.epc_tbl_id')
               ->leftjoin('quality_check_codes', 'formers.qc_code_tbl_id', '=', 'quality_check_codes.qc_code_tbl_id')
               ->where('electronic_product_codes.epc', '=', $epc)
               ->get();
            //    ->where('quality_check_codes.qc_code', '=', 0) // 0 = passed former
            //    ->count();
   
               return $epc_total_passed;
           // calculate mould rejection ratio
           // this condition is to avoid division by zero error
           if ($epc_total_formers != 0 && $epc_total_passed != 0) {
               $mould_rejection_ratio = 1 - ($epc_total_passed / $epc_total_formers);
               $mould_rejection_ratio = round($mould_rejection_ratio * 100, 2) . '%';
           } else {
               $mould_rejection_ratio = "0%";
           }
   
           return $mould_rejection_ratio;
    }
}
