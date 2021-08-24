<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MouldModel extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'mould_mdl_tbl_id';
    
    protected $table = 'mould_models';

    protected $fillable = ['mould_mdl_id', 'description'];
}
