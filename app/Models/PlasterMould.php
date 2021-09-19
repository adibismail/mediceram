<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlasterMould extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'plaster_mould_tbl_id';
    
    protected $table = 'plaster_moulds';

    protected $fillable = ['created_at', 'epc_tbl_id', 'mould_mdl_tbl_id', 'init_weight'];

    /*
    * Every Plaster Mould has a corresponding EPC used to identify the particular mould
    */
    public function epc()
    {
        return $this->belongsTo(ElectronicProductCode::class, 'epc_tbl_id', 'epc_tbl_id');
    }

    public function model()
    {
        return $this->belongsTo(MouldModel::class, 'mould_mdl_tbl_id', 'mould_mdl_tbl_id');
    }
}
