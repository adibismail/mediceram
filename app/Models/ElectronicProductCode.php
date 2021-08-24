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
}
