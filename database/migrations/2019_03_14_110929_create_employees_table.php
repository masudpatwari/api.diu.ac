<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->enum('type', ['teacher', 'employee']);
            $table->integer('designation_id');
            $table->integer('department_id');
            $table->string('office_email', 40);
            $table->string('private_email', 40);
            $table->string('personal_phone_no', 12);
            $table->string('alternative_phone_no', 12)->nullable();
            $table->string('spous_phone_no', 12)->nullable();
            $table->string('parents_phone_no', 12)->nullable();
            $table->string('other_phone_no', 12)->nullable();
            $table->string('office_phone_no', 12)->nullable();
            $table->string('home_phone_no', 12)->nullable();
            $table->string('gurdian_phone_no', 12)->nullable();
            $table->enum('jobtype', ['Part Time', 'Full Time']);
            $table->integer('date_of_birth')->nullable();
            $table->integer('date_of_join')->nullable();
            $table->integer('campus_id');
            $table->string('nid_no', 20)->nullable();
            $table->string('office_address', 100);
            $table->string('profile_photo_file', 100)->nullable();
            $table->string('signature_card_photo_file', 100)->nullable();
            $table->string('cover_photo_file', 100)->nullable();
            $table->string('password', 200);
            $table->integer('activestatus');
            $table->integer('lock_for_rms')->nullable();
            $table->text('rms_permissions')->nullable();
            $table->string('weekly_working_hours', 7)->nullable();
            $table->integer('salary_report_sort_id')->nullable();
            $table->integer('created_by');
            $table->integer('supervised_by')->nullable();
            $table->integer('shortPosition_id');
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
        Schema::dropIfExists('employees');
    }
}
