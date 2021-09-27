<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Exports\ExportOrders;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\BeaconsController;
use App\Http\Controllers\WorkersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MouldModelsController;
use App\Http\Controllers\OrdersMonitorController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'test' => 'test',
    ]);
})->middleware(['guest']);

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/* 
    BEACONS 
*/
Route::get('beacons', [BeaconsController::class, 'index'])
    ->middleware(['auth'])
    ->name('beacons');

Route::post('beacons-store', [BeaconsController::class, 'store'])
    ->middleware(['auth'])
    ->name('beacons-store');

Route::post('beacons-update', [BeaconsController::class, 'update'])
    ->middleware(['auth'])
    ->name('beacons-update');

Route::post('beacons-delete', [BeaconsController::class, 'delete'])
    ->middleware(['auth'])
    ->name('beacons-delete');
    
/* 
    WORKERS 
*/
Route::get('workers', [WorkersController::class, 'index'])
    ->middleware(['auth'])
    ->name('workers');

Route::post('workers-store', [WorkersController::class, 'store'])
    ->middleware(['auth'])
    ->name('workers-store');

Route::post('workers-update', [WorkersController::class, 'update'])
    ->middleware(['auth'])
    ->name('workers-update');

Route::post('workers-delete', [WorkersController::class, 'delete'])
    ->middleware(['auth'])
    ->name('workers-delete');

Route::get('get-avail-beacons', [WorkersController::class, 'get_avail_beacons'])
    ->middleware(['auth'])
    ->name('get-avail-beacons');
    
/* 
    CUSTOMERS 
*/
Route::get('customers', [CustomersController::class, 'index'])
    ->middleware(['auth'])
    ->name('customers');

Route::post('customers-store', [CustomersController::class, 'store'])
    ->middleware(['auth'])
    ->name('customers-store');
    
Route::post('customers-update', [CustomersController::class, 'update'])
    ->middleware(['auth'])
    ->name('customers-update');

Route::post('customers-delete', [CustomersController::class, 'delete'])
    ->middleware(['auth'])
    ->name('customers-delete');

/* 
    MOULD MODELS 
*/
Route::get('mould-models', [MouldModelsController::class, 'index'])
    ->middleware(['auth'])
    ->name('mould-models');

Route::post('mould-models-store', [MouldModelsController::class, 'store'])
    ->middleware(['auth'])
    ->name('mould-models-store');

Route::post('mould-models-update', [MouldModelsController::class, 'update'])
    ->middleware(['auth'])
    ->name('mould-models-update');

Route::post('mould-models-delete', [MouldModelsController::class, 'delete'])
    ->middleware(['auth'])
    ->name('mould-models-delete');
    
/* 
    ORDERS 
*/
Route::get('orders', [OrdersController::class, 'index'])
    ->middleware(['auth'])
    ->name('orders');

Route::post('orders-store', [OrdersController::class, 'store'])
    ->middleware('auth')
    ->name('orders-store');

Route::post('orders-update', [OrdersController::class, 'update'])
    ->middleware('auth')
    ->name('orders-update');

Route::post('orders-delete', [OrdersController::class, 'delete'])
    ->middleware('auth')
    ->name('orders-delete');

Route::post('orders-complete', [OrdersController::class, 'complete'])
    ->middleware('auth')
    ->name('orders-complete');

Route::get('orders-export/{id}', [OrdersController::class, 'export'])
    ->middleware('auth')
    ->name('orders-export');

/* 
    ORDERS MONITOR
*/
Route::get('orders-monitor', [OrdersMonitorController::class, 'index'])
    ->middleware(['auth'])
    ->name('orders-monitor');

Route::get('orders-monitor-view-station/{id}', [OrdersMonitorController::class, 'view_station'])
    ->middleware('auth')
    ->name('orders-monitor-view-station');

Route::get('get-former-data/{id}', [OrdersMonitorController::class, 'get_former_data'])
    ->middleware('auth')
    ->name('former-data');

Route::get('get-former-data-table/{id}', [OrdersMonitorController::class, 'get_former_data_table'])
    ->middleware('auth')
    ->name('former-data-table');

Route::get('get-moulds-for-date', [OrdersMonitorController::class, 'get_moulds_for_date'])
    ->middleware('auth')
    ->name('moulds-for-date');

Route::get('get-moulds-for-failure_rate', [OrdersMonitorController::class, 'moulds_for_failure_rate'])
    ->middleware('auth')
    ->name('moulds-for-failure_rate');

if (env('APP_DEBUG')){
    Route::get('test', [TestController::class, 'index'])
    ->middleware('auth')
    ->name('test');
}




require __DIR__.'/auth.php';
