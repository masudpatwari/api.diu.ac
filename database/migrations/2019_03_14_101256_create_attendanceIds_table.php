<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendanceIds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('att_data_id');
            $table->integer('att_card_id');
            $table->integer('created_by');
            $table->integer('deleted_by')->nullable();;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendanceIds');
    }
}
