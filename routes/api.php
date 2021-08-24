<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Handheld Reader
Route::get('get_new_epc', [ApiController::class, 'get_new_epc']);
Route::get('get_mould_reg_data', [ApiController::class, 'get_mould_reg_data']);
Route::post('post_mould_data', [ApiController::class, 'post_mould_data']);

// Cast Processing System
Route::get('get_workers_data', [ApiController::class, 'get_workers_data']);
Route::get('get_mould_data', [ApiController::class, 'get_mould_data']);
Route::post('post_former_data', [ApiController::class, 'post_former_data']);