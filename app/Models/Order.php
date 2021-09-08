<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'order_tbl_id';
    
    protected $table = 'orders';

    protected $fillable = ['prod_date', 'order_created_at', 'fmr_opt_wgt_min', 'fmr_opt_wgt_max', 'order_qty', 'done_qty', 'failed_qty', 'status', 'customer_tbl_id', 'mould_mdl_tbl_id', 'cs_tbl_id'];


    /*
    * Every Plaster Mould has a corresponding EPC used to identify the particular mould
    */
    public function mould_model()
    {
        return $this->belongsTo(MouldModel::class, 'mould_mdl_tbl_id', 'mould_mdl_tbl_id');
    }

      /*
    * Every order has formers to fullfill data that order
    */
    public function formers()
    {
        return $this->hasMany(Former::class, 'order_tbl_id', 'order_tbl_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_tbl_id', 'customer_tbl_id');
    }
}
