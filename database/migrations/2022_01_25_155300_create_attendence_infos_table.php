<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendenceInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->double('course_id')->nullable();
            $table->string('course_name')->nullable();
            $table->string('course_code')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->boolean('attended')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendence_infos');
    }
}
