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
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
		$orders = Order::leftjoin('mould_models', 'orders.mould_mdl_tbl_id', '=', 'mould_models.mould_mdl_tbl_id')
            ->leftjoin('casting_stations', 'orders.cs_tbl_id', '=', 'casting_stations.cs_tbl_id')
            ->leftjoin('customers', 'orders.customer_tbl_id', '=', 'customers.customer_tbl_id')
            ->whereRaw('orders.order_qty != orders.done_qty')
            ->where('status', '1')
            ->where('orders.prod_date', '<=', Carbon::today())
            ->get();

		$incomplete_orders = Order::leftjoin('mould_models', 'orders.mould_mdl_tbl_id', '=', 'mould_models.mould_mdl_tbl_id')
            ->leftjoin('casting_stations', 'orders.cs_tbl_id', '=', 'casting_stations.cs_tbl_id')
            ->leftjoin('customers', 'orders.customer_tbl_id', '=', 'customers.customer_tbl_id')
            ->whereRaw('orders.order_qty != orders.done_qty')
            ->where('status', '1')
            ->where('orders.prod_date', '<=', Carbon::today())
            ->get();

        $upcoming_orders = Order::leftjoin('mould_models', 'orders.mould_mdl_tbl_id', '=', 'mould_models.mould_mdl_tbl_id')
            ->leftjoin('casting_stations', 'orders.cs_tbl_id', '=', 'casting_stations.cs_tbl_id')
            ->leftjoin('customers', 'orders.customer_tbl_id', '=', 'customers.customer_tbl_id')
            ->whereRaw('orders.order_qty != orders.done_qty')
            ->where('status', '1')
            ->where('orders.prod_date', '>', Carbon::today())
            ->get();

        $completed_orders = Order::leftjoin('mould_models', 'orders.mould_mdl_tbl_id', '=', 'mould_models.mould_mdl_tbl_id')
            ->leftjoin('casting_stations', 'orders.cs_tbl_id', '=', 'casting_stations.cs_tbl_id')
            ->leftjoin('customers', 'orders.customer_tbl_id', '=', 'customers.customer_tbl_id')
            ->whereRaw('orders.order_qty = orders.done_qty')
            ->where('status', '1')
            ->get();

        $customers = Customer::get();

        $mould_models = MouldModel::get();
        
        $casting_stations = CastingStation::get();
        
        return Inertia::render('Orders/Index', [
            'orders' => $orders,
            'incomplete_orders' => $incomplete_orders,
            'upcoming_orders' => $upcoming_orders,
            'completed_orders' => $completed_orders,
            'customers' => $customers,
            'mould_models' => $mould_models,
            'casting_stations' => $casting_stations,
        ]);
    }

    public function store(Request $request, Order $order) {
        //Log::channel('post_orders_data_logger')->info($request->all());
        
        $order->create(
            $this->validate($request, [
                'prod_date' => ['required'],
                'fmr_opt_wgt_min' => ['required', 'numeric', 'between:0.00,9999.99'],
                'fmr_opt_wgt_max' => ['required', 'numeric', 'between:0.00,9999.99'],
                'order_qty' => ['required'],
                'customer_tbl_id' => ['required'],
                'mould_mdl_tbl_id' => ['required'],
                'cs_tbl_id' => ['required'],
            ])
        );

        return Redirect::route('orders')->with('success_msg', 'Order created.');
    }
    
    public function update(Request $request) {
        //Log::channel('post_orders_data_logger')->info($request->all());

        $order = Order::find($request->order_tbl_id);
        
        $order->update(
            $this->validate($request, [
                'prod_date' => ['required'],
                'fmr_opt_wgt_min' => ['required', 'numeric', 'between:0.00,9999.99'],
                'fmr_opt_wgt_max' => ['required', 'numeric', 'between:0.00,9999.99'],
                'order_qty' => ['required'],
                'customer_tbl_id' => ['required'],
                'mould_mdl_tbl_id' => ['required'],
                'cs_tbl_id' => ['required'],
            ])
        );

        return Redirect::route('orders')->with('success_msg', 'Order updated.');
    }

    public function delete(Request $request) {
        //Log::channel('post_orders_data_logger')->info($request->all());
        
        Order::where('order_tbl_id', $request->order_tbl_id)
            ->update(['status' => 0]);

        return Redirect::route('orders')->with('success_msg', 'Order deleted.');
    }

    public function export($id) {
        return Excel::download(new ExportOrders($id), 'order.xlsx');
    }
}
