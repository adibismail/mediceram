<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlasterMouldingStation extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'pms_tbl_id';
    
    protected $table = 'plaster_moulding_stations';

    protected $fillable = ['plaster_moulding_station_id'];
}
