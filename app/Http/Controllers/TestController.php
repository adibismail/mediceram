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

        return redirect()->route('dashboard');
    }
}
