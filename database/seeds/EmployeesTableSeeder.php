<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('employees')->insert([
            'name' => "Md. Mesbaul Islam",
            'type' => "employee",
            'designation_id' => 1,
            'department_id' => 1,
            'office_email' => "mesbaul.it@diu-bd.net",
            'private_email' => "mesbaul.it@diu-bd.net",
            'personal_phone_no' => "01738120411",
            'jobtype' => "Full Time",
            'campus_id' => 1,
            'office_address' => "Banani",
            'password' => md5(123),
            'activestatus' => 1,
            'created_by' => 1,
            'shortPosition_id' => 1,
        ]);
    }
}
