<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastingStationAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casting_station_attendance', function (Blueprint $table) {
            $table->bigIncrements('cs_att_tbl_id');
            $table->datetime('datetime');
			$table->unsignedBigInteger('beacon_tbl_id')->index();
			$table->unsignedBigInteger('cs_tbl_id')->index();
			
			$table->foreign('beacon_tbl_id')->references('beacon_tbl_id')->on('beacons');
			$table->foreign('cs_tbl_id')->references('cs_tbl_id')->on('casting_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casting_station_attendance');
    }
}
