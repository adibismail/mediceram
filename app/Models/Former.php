<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Former extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'former_tbl_id';
    
    protected $table = 'formers';

    protected $fillable = ['former_weight', 'created_at', 'epc_tbl_id', 'qc_code_tbl_id', 'cs_tbl_id', 'beacon_tbl_id'];

    public function epc()
    {
        return $this->belongsTo(ElectronicProductCode::class, 'epc_tbl_id', 'epc_tbl_id');
    }

    public function qc()
    {
        return $this->belongsTo(QualityCheckCode::class, 'qc_code_tbl_id', 'qc_code_tbl_id');
    }
}
