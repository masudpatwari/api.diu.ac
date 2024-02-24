<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveApplicationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaveApplicationHistories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leaveApplication_id');
            $table->string('kindofleave', 100);
            $table->integer('start_date');
            $table->integer('end_date');
            $table->integer('number_of_days');
            $table->integer('created_by');
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
        Schema::dropIfExists('leaveApplicationHistories');
    }
}
