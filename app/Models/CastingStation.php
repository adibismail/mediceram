<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CastingStation extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'cs_tbl_id';
    
    protected $table = 'casting_stations';

    protected $fillable = ['casting_station_id'];
}
