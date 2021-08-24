<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'dprt_tbl_id';
    
    protected $table = 'departments';

    protected $fillable = ['dprt_name'];
}
