<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'beacon_tbl_id';
    
    protected $table = 'beacons';

    protected $fillable = ['beacon_id', 'status'];
}
