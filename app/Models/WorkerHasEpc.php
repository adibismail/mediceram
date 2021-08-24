<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerHasEpc extends Model
{
    public $timestamps = false;
	    
    protected $table = 'worker_has_epcs';

    protected $fillable = ['epc_tbl_id', 'worker_tbl_id'];
}
