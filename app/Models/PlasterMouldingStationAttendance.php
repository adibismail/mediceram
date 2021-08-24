<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlasterMouldingStationAttendance extends Model
{
    public $timestamps = false;
	
	public $primaryKey = 'pms_att_tbl_id';
    
    protected $table = 'plaster_moulding_station_attendance';

    protected $fillable = ['datetime', 'worker_tbl_id', 'pms_tbl_id'];
}
