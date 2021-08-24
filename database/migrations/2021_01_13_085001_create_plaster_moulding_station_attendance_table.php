<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlasterMouldingStationAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plaster_moulding_station_attendance', function (Blueprint $table) {
            $table->bigIncrements('pms_att_tbl_id');
            $table->datetime('datetime');
			$table->unsignedBigInteger('worker_tbl_id')->index();
			$table->unsignedBigInteger('pms_tbl_id')->index();
			
			$table->foreign('worker_tbl_id')->references('worker_tbl_id')->on('workers');
			$table->foreign('pms_tbl_id')->references('pms_tbl_id')->on('plaster_moulding_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plaster_moulding_station_attendance');
    }
}
