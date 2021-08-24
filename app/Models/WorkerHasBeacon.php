<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerHasBeacon extends Model
{
    public $timestamps = false;
    
    protected $table = 'worker_has_beacons';

    protected $fillable = ['worker_tbl_id', 'beacon_tbl_id', 'date_assigned', 'date_unassigned'];
}
