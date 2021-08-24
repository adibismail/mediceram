<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
		$customers = Customer::get();

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
        ]);
    }

    public function store(Request $request, Customer $customers) {
        //Log::channel('post_customers_data_logger')->info($request);
        
        $customers->create(
            $this->validate($request, [
                'customer_id' => ['required', 'unique:customers,customer_id', 'max:50'],
            ])
        );
        
        return Redirect::route('customers')->with('success_msg', 'Customer created.');
    }

    public function update(Request $request) {
        //Log::channel('post_customers_data_logger')->info($request);

        $customers = Customer::find($request->customer_tbl_id);
        
        $customers->update(
            $this->validate($request, [
                'customer_id' => ['required', 'unique:customers,customer_id,' . $request->customer_tbl_id . ',customer_tbl_id', 'max:50'],
            ])
        );
        
        return Redirect::route('customers')->with('success_msg', 'Customer updated.');
    }

    public function delete(Request $request) {
        //Log::channel('post_customers_data_logger')->info($request);

        try {
            Customer::destroy($request->customer_tbl_id);
            return redirect()->back()->with('success_msg', 'Customer deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_msg', 'Customer could not be deleted as it is already tied with some orders.');
        }
    }
}
