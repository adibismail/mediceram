<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Beacon;
use App\Models\Former;
use App\Models\CastingStation;
use App\Models\QualityCheckCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ElectronicProductCode;
use App\Models\CastingStationAttendance;
use App\Models\MouldModel;
use App\Models\OrderHasFormer;
use App\Models\PlasterMould;

class StoreFormerDataService
{
    public function StoreFormerData($epc, $bid, $former_weight, $date_time, $failure_code, $casting_station_id)
    {
       
        $date = date_create($date_time);
        $date = date_format($date, "Y-m-d");

        DB::beginTransaction();
        try {
            $epc = ElectronicProductCode::firstWhere('epc', strtoupper($epc));
            $plaster_mould = PlasterMould::firstWhere('epc_tbl_id', $epc->epc_tbl_id);
            $beacon = Beacon::firstWhere('beacon_id', strtolower($bid));
            $qc_code = QualityCheckCode::firstWhere('qc_code', $failure_code);
            $casting_station = CastingStation::firstWhere('casting_station_id', $casting_station_id);

            // raw date_format matches HOUR only
            // 1 epc = 1 mould = max 24 formers everyday (1 hour = 1 former / day)
            $former_exists = Former::where('epc_tbl_id', '=', $epc->epc_tbl_id)
                ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H")'), '=', Carbon::parse($date_time)->format('Y-m-d H'))
                ->exists();

            // if first time this former is scanned today & passed
            if (!$former_exists && $failure_code == 0) {
                $former = new Former;
                $former->former_weight = $former_weight;
                $former->created_at = $date_time;
                $former->epc_tbl_id = $epc->epc_tbl_id;
                $former->qc_code_tbl_id = $qc_code->qc_code_tbl_id;
                $former->cs_tbl_id = $casting_station->cs_tbl_id;
                $former->beacon_tbl_id = $beacon->beacon_tbl_id;
                $former->save();

                $order = Order::where('status', '1')
                    ->where('orders.cs_tbl_id', $former->cs_tbl_id)
                    ->where('orders.prod_date', '<=', Carbon::today())
                    ->where('orders.mould_mdl_tbl_id', '=', $plaster_mould->mould_mdl_tbl_id)
                    ->whereRaw('orders.done_qty < orders.order_qty')
                ->first();
                $order->increment('done_qty');

                $former->order_tbl_id = $order->order_tbl_id;
                $former->update();
                OrderHasFormer::updateOrCreate(
                    [   // always update/create record
                        'order_tbl_id' => $order->order_tbl_id,
                        'former_tbl_id' => $former->former_tbl_id
                    ],
                    [   // do nothing
                        
                    ]
                );
            } 

            // if first former today & failed
            else if (!$former_exists && $failure_code != 0) {
                $former = new Former;
                $former->former_weight = $former_weight;
                $former->created_at = $date_time;
                $former->epc_tbl_id = $epc->epc_tbl_id;
                $former->qc_code_tbl_id = $qc_code->qc_code_tbl_id;
                $former->cs_tbl_id = $casting_station->cs_tbl_id;
                $former->beacon_tbl_id = $beacon->beacon_tbl_id;
                $former->save();

                $order = Order::where('status', '1')
                    ->where('orders.cs_tbl_id', $former->cs_tbl_id)
                    ->where('orders.prod_date', '<=', Carbon::today())
                    ->where('orders.mould_mdl_tbl_id', '=', $plaster_mould->mould_mdl_tbl_id)
                    ->whereRaw('orders.done_qty < orders.order_qty')
                    ->first();
                $order->increment('failed_qty');
                
                $former->order_tbl_id = $order->order_tbl_id;
                $former->update();
                OrderHasFormer::updateOrCreate(
                    [   // always update/create record
                        'order_tbl_id' => $order->order_tbl_id,
                        'former_tbl_id' => $former->former_tbl_id
                    ],
                    [   // do nothing
                        
                    ]
                );
            }

            // if former rescanned today
            else {
                $former = Former::where('epc_tbl_id', '=',  $epc->epc_tbl_id)
                    ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H")'), '=', Carbon::parse($date_time)->format('Y-m-d H'))
                    ->first();
                
                // if now passed & prev passed
                // if now failed & prev failed
                if (($failure_code == 0 && $former->qc_code_tbl_id == $qc_code->qc_code_tbl_id) || ($failure_code != 0 && $former->qc_code_tbl_id == $qc_code->qc_code_tbl_id) ) {
                    $former->update([
                        'created_at' => $date_time, 
                        'former_weight' =>  $former_weight, 
                        'qc_code_tbl_id' => $qc_code->qc_code_tbl_id,
                    ]);

                    $order = Order::where('status', '1')
                        ->where('orders.cs_tbl_id', $former->cs_tbl_id)
                        ->where('orders.prod_date', '<=', Carbon::today())
                        ->where('orders.mould_mdl_tbl_id', '=', $plaster_mould->mould_mdl_tbl_id)
                        ->whereRaw('orders.done_qty < orders.order_qty')
                        ->first();
                }

                // if now passed & prev failed
                else if ($failure_code == 0 && $former->qc_code_tbl_id != $qc_code->qc_code_tbl_id) {
                    $former->update([
                        'created_at' => $date_time, 
                        'former_weight' =>  $former_weight, 
                        'qc_code_tbl_id' => $qc_code->qc_code_tbl_id
                    ]);

                    $order = Order::where('status', '1')
                        ->where('orders.cs_tbl_id', $former->cs_tbl_id)
                        ->where('orders.prod_date', '<=', Carbon::today())
                        ->where('orders.mould_mdl_tbl_id', '=', $plaster_mould->mould_mdl_tbl_id)
                        ->whereRaw('orders.done_qty < orders.order_qty')
                        ->first();

                    $order->increment('done_qty');
                    $order->decrement('failed_qty');
                }

                // if now failed & prev passed
                else if ($failure_code != 0 && $former->qc_code_tbl_id != $qc_code->qc_code_tbl_id) {
                    $former->update([
                        'created_at' => $date_time, 
                        'former_weight' =>  $former_weight, 
                        'qc_code_tbl_id' => $qc_code->qc_code_tbl_id
                    ]);

                    $order = Order::where('status', '1')
                        ->where('orders.cs_tbl_id', $former->cs_tbl_id)
                        ->where('orders.prod_date', '<=', Carbon::today())
                        ->where('orders.mould_mdl_tbl_id', '=', $plaster_mould->mould_mdl_tbl_id)
                        ->whereRaw('orders.done_qty < orders.order_qty')
                        ->first();

                    $order->decrement('done_qty');
                    $order->increment('failed_qty');
                }
            }

            ElectronicProductCode::updateOrCreate(
                [   // find if epc exists
                    'epc_tbl_id' => $epc->epc_tbl_id
                ],
                [   // then update last used date
                    'last_used' => $date
                ]
            );

            $casting_station = CastingStation::firstWhere('casting_station_id', $casting_station_id);
            $casting_station_attendance = new CastingStationAttendance();
            $casting_station_attendance->datetime = $date_time;
            $casting_station_attendance->beacon_tbl_id = $beacon->beacon_tbl_id;
            $casting_station_attendance->cs_tbl_id = $casting_station->cs_tbl_id;
            $casting_station_attendance->save();

            DB::commit();

            $msg = "Data validated and stored.";

            return array("msg", $msg);
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('post_former_data_logger')->info($e);
            $msg = "Error, contact system admin.";

            return array("err_msg", $msg);
        }
    }
}
