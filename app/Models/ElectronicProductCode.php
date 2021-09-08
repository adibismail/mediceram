<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectronicProductCode extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'epc_tbl_id';
    
    protected $table = 'electronic_product_codes';

    protected $fillable = ['epc', 'tid', 'created_at', 'last_used', 'pms_tbl_id'];

    /*
    * Every EPC corresponds to a unique plaster mould 
    */
    public function plaster()
    {
        return $this->hasOne(PlasterMould::class, 'epc_tbl_id', 'epc_tbl_id');
    }

    
    /*
    * Each epc/plaster mould is made at a specific plaster moulding station
    */
    public function pms()
    {
        return $this->hasOne(PlasterMouldingStation::class, 'pms_tbl_id', 'pms_tbl_id');
    }

    public function worker(){
        return $this->belongsToMany(Worker::class, 'worker_has_epcs', 'epc_tbl_id', 'worker_tbl_id');
    }


}
