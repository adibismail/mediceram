<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlasterMould extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'plaster_mould_tbl_id';
    
    protected $table = 'plaster_moulds';

    protected $fillable = ['created_at', 'epc_tbl_id', 'mould_mdl_tbl_id'];
}
