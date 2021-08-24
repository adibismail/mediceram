<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'worker_tbl_id';
    
    protected $table = 'workers';

    protected $fillable = ['worker_id', 'worker_name', 'status'];
}
