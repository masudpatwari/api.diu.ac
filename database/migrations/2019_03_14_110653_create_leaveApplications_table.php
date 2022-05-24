<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaveApplications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->enum('status', ['Pending', 'Approved', 'Deny_By_Others', 'Self_Deny', 'Withdraw']);
            $table->integer('pending_in_employee_id')->nullable();
            $table->text('cause', 200);
            $table->string('need_permission', 200);
            $table->integer('accept_salary_difference');
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
        Schema::dropIfExists('leaveApplications');
    }
}
