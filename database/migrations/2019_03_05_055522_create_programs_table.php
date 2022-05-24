<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('faculty_id');
            $table->integer('department_id');
            $table->string('name', 100);
            $table->string('short_name', 100);
            $table->text('description')->nullable();
            $table->string('duration', 100);
            $table->string('credit', 100);
            $table->double('total_fee', 10,2);
            $table->string('shift', 50);
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
        Schema::dropIfExists('programs');
    }
}
