<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceIdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('attendanceIds')->insert([
            'employee_id' => 1,
            'att_data_id' => 111111,
            'att_card_id' => 222222,
            'created_by' => 1,
        ]);
    }
}
