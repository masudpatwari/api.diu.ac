<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('taskType_id');
            $table->string('location', 20);
            $table->string('status', 20);
            $table->string('detail', 200);
            $table->integer('start_datetime');
            $table->integer('end_datetime');
            $table->integer('parent_id');
            $table->integer('priority');
            $table->integer('created_by');
            $table->integer('reveived_by');
            $table->integer('doned_by');
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
        Schema::dropIfExists('tasks');
    }
}
