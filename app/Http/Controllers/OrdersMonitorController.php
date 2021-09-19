<?php

namespace App\Http\Controllers;

use App\Exports\ExportOrders;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Customer;
use App\Models\MouldModel;
use Illuminate\Http\Request;
use App\Models\CastingStation;
use App\Models\ElectronicProductCode;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Models\Former;
use App\Models\PlasterMould;
use App\Models\QualityCheckCode;
use Hamcrest\Type\IsObject;

class OrdersMonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $orders = Order::with('mould_model')->get();//->groupBy('customer_tbl_id');
        $customers = Customer::get();

        foreach ($orders as $order){
            $order->mould_description = $order->mould_model->description;
            $order->mould_id = $order->mould_model->mould_mdl_id;
        }
        $orders = $orders->groupBy('customer_tbl_id');
        return Inertia::render('OrdersMonitor/former-table', [
            'customers' => $customers, 
            'orders' => $orders,
        ]);


    }

    public function view_station($id) {
        $casting_stations = CastingStation::get();

        // return Excel::download(new ExportOrders($id), 'order.xlsx');
        $orders = Order::with('mould_model')->get();//->groupBy('customer_tbl_id');
        $customers = Customer::get();

        foreach ($orders as $order){
            $order->mould_description = $order->mould_model->description;
            $order->mould_id = $order->mould_model->mould_mdl_id;
        }
        $orders = $orders->groupBy('customer_tbl_id');

        $epc = ElectronicProductCode::with('plaster')->get();
        return Inertia::render('OrdersMonitor/View-Station', [
            'casting_stations' => $casting_stations,
            'plaster_moulds' => $epc,
            'customers' => $customers, 
            'orders' => $orders,
        ]);
    }

    public function get_former_data($id){
        $former_data = Former::where('order_tbl_id', $id)
        ->where('created_at', '>=', Carbon::today())
        ->where('former_weight', '!=', '-1.00')
        ->get();
        $order = Order::with('mould_model')->find($id);
        return response()->json([
            "former_data" => $former_data,
            "order" => $order
        ], 200);
    }

    public function get_former_data_table($id){
        $former_data = Former::where('order_tbl_id', $id)
        ->with('qc')
        ->get();
        
        $former_data_export = Former::where('order_tbl_id', $id)
        ->where('former_weight', '!=', '-1.00')
        ->with('qc')
        ->get();
        $order = Order::with('mould_model', 'customer')->find($id);

        foreach ($former_data as $former){
            if ($order != null){
                $former->max = $order->fmr_opt_wgt_max;
                $former->min = $order->fmr_opt_wgt_min;
                $former->qc_name = $former->qc->qc_name;

                switch ($former->qc->qc_code) {
                    case 0:
                        $former->status = "Pass";
                        break;
                    case 5:
                        $former->status = "Overweight: ".$former->former_weight." kg";
                        break;
                    case 6:
                        $former->status = "Underweight: ".$former->former_weight." kg";
                        break;
                    default:
                        $former->status = "Visual Failure Type";
                } 

            }
        }
        foreach ($former_data_export as $former){
            if ($order != null){
                $former->max = $order->fmr_opt_wgt_max;
                $former->min = $order->fmr_opt_wgt_min;
                $former->qc_name = $former->qc->qc_name;
            }
        }
        return response()->json([
            "former_data" => $former_data,
            "former_data_export" => $former_data_export,
            "order" => $order
        ], 200);
    }

    public function get_moulds_for_date(Request $request){
        $date_start = $request['dates'][0];
        $date_end = $request['dates'][1];
        $plaster_moulds = PlasterMould::with('epc')->whereBetween('created_at', [$date_start, $date_end])->get();
        foreach ($plaster_moulds as $pm){
            $pm->epc_title = $pm->epc->epc;
        }
        return response()->json([
            "moulds" => $plaster_moulds,
        ], 200);
  
    }

    public function moulds_for_failure_rate(Request $request){
        $date_start = new Carbon("2021-03-17");
        $date_end = new Carbon("2021-09-18");
        $date_end = $date_end->addDays(1)->subSecond(1);
        $isConsecutive = $request['isConsecutive'];
        $numberValue = $request['numberValue'];
        $plaster_moulds = PlasterMould::with('epc', 'model', 'epc.pms', 'epc.worker')
                        ->whereBetween('created_at', [$date_start, $date_end])->get();
        $epcs = $plaster_moulds->pluck('epc_tbl_id');
        $formers = Former::whereIn('epc_tbl_id', $epcs)->get()->groupBy('epc_tbl_id');
        $qc_codes = QualityCheckCode::get()->groupBy('qc_code_tbl_id');
        $failure_array = []; //Array of EPC Table IDs that meet the failure rate
        $failure_objects = []; //Keep track of consecutive failures and rejection rate for each epc
        foreach ($formers as $epc => $former_array){
            $consecutive_count = 0;
            $highest_consecutive_count = 0;
            $failure_count = 0;
            foreach ($former_array as $former){
                if ($qc_codes[$former->qc_code_tbl_id][0]->qc_code != 0){
                    $failure_count++;
                    $consecutive_count++;
                }else{
                    if ($consecutive_count > $highest_consecutive_count){
                        $highest_consecutive_count = $consecutive_count;
                    }
                    $consecutive_count = 0;
                }
            }
            if ($consecutive_count > $highest_consecutive_count){
                $highest_consecutive_count = $consecutive_count;
            }
            if (!$isConsecutive){
                $total_count = count($former_array);
                $failure_percentage = $failure_count/$total_count*100;
                if ($failure_percentage >= $numberValue){
                    array_push($failure_array, $former->epc_tbl_id);
                    $failure_object = (object)[];
                    $failure_object->epc = $former->epc_tbl_id;
                    $failure_object->consecutive = $highest_consecutive_count;
                    $failure_object->rejection_ratio = $failure_percentage;
                    $failure_objects[$former->epc_tbl_id] = $failure_object;
                }
            }else{
                $total_count = count($former_array);
                $failure_percentage = $failure_count/$total_count*100;
                if ($highest_consecutive_count >= $numberValue){
                    array_push($failure_array, $former->epc_tbl_id);
                    $failure_object = (object)[];
                    $failure_object->epc = $former->epc_tbl_id;
                    $failure_object->consecutive = $highest_consecutive_count;
                    $failure_object->rejection_ratio = $failure_percentage;
                    $failure_objects[$former->epc_tbl_id] = $failure_object;
                }
            }
        }

        $reject_moulds = $plaster_moulds->whereIn('epc_tbl_id', $failure_array);
        $formers = Former::whereIn('epc_tbl_id', $failure_array)->orderBy('created_at')->get()->groupBy('epc_tbl_id');
        foreach ($reject_moulds as $mould){
            $mould->latest_former = ($formers[$mould->epc->epc_tbl_id])->last()->created_at;
            $mould->rejection_ratio = $failure_objects[$mould->epc->epc_tbl_id]->rejection_ratio;
            $mould->consecutive = $failure_objects[$mould->epc->epc_tbl_id]->consecutive;
            $mould->worker = $mould->epc->worker[0];
        }

        //If $failure_array contains only 1 result it will be an object
        //Data table requires an array so convert $reject_moulds to an array;
        $array = [];
        foreach ($reject_moulds as $key => $value){
            array_push($array, $value);
        }
        return response()->json([
            "moulds" => $array,
        ], 200);
        

    }
}
