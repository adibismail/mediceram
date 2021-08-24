<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityCheckCode extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'qc_code_tbl_id';
    
    protected $table = 'quality_check_codes';

    protected $fillable = ['qc_code', 'qc_name'];
}
