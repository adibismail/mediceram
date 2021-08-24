<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerHasBeaconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_has_beacons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('worker_tbl_id')->index();
            $table->unsignedBigInteger('beacon_tbl_id')->index();
			$table->datetime('date_assigned')->nullable();
            $table->datetime('date_unassigned')->nullable();
			
			$table->foreign('worker_tbl_id')->references('worker_tbl_id')->on('workers');
			$table->foreign('beacon_tbl_id')->references('beacon_tbl_id')->on('beacons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_has_beacons');
    }
}
