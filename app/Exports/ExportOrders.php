<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportOrders implements FromCollection, WithHeadings
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function headings(): array
    {
        return [
            'Datetime',
            'Weight',
            'Min Optimum Weight',
            'Max Optimum Weight',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $export_order = Order::leftjoin('order_has_formers', 'orders.order_tbl_id', '=', 'order_has_formers.order_tbl_id')
            ->leftjoin('formers', 'order_has_formers.former_tbl_id', '=', 'formers.former_tbl_id')
            ->selectRaw('formers.created_at, formers.former_weight, orders.fmr_opt_wgt_min, orders.fmr_opt_wgt_max')
            ->where('orders.order_tbl_id', $this->id)
            ->where('formers.qc_code_tbl_id', '16')
            ->get();
        
        return $export_order;
    }
}
