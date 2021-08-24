<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerHasDepartment extends Model
{
    public $timestamps = false;
	    
    protected $table = 'worker_has_department';

    protected $fillable = ['worker_tbl_id', 'dprt_tbl_id'];
}
