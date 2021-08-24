<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CastingStationAttendance extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'cs_att_tbl_id';
    
    protected $table = 'casting_station_attendance';

    protected $fillable = ['datetime', 'beacon_tbl_id', 'cs_tbl_id'];
}
