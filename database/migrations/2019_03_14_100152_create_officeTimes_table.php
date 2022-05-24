<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officeTimes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->string('day', 15);
            $table->enum('type', ['offday', 'fixed', 'flexible']);
            $table->integer('start_time')->nullable();
            $table->integer('end_time')->nullable();
            $table->integer('time_duration')->nullable();
            $table->integer('offDay');
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
        Schema::dropIfExists('officeTimes');
    }
}
