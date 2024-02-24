<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachineAccessTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machineAccessTimes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('att_data_id');
            $table->integer('datetime');
            $table->integer('attendanceMachine_id');
            $table->string('day', 20);
            $table->enum('type', ['fixed', 'flexible']);
            $table->integer('start_time')->nullable();
            $table->integer('end_time')->nullable();
            $table->integer('time_duration')->nullable();
            $table->integer('offDay');
            $table->integer('attendanceDataFile_id');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machineAccessTimes');
    }
}
