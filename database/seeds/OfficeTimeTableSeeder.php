<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('officeTimes')->insert([
			[
	            'employee_id' => 1,
	            'day' => 'Friday',
	            'type' => 'fixed',
	            'start_time' => 1554868800,
	            'end_time' => 1554897600,
	            'time_duration' => NULL,
	            'offDay' => 0,
	            'created_by' => 1,
	        ],
	        [
	            'employee_id' => 1,
	            'day' => 'Saturday',
	            'type' => 'fixed',
	            'start_time' => 1554868800,
	            'end_time' => 1554897600,
	            'time_duration' => NULL,
	            'offDay' => 0,
	            'created_by' => 1,
	        ],
	        [
	            'employee_id' => 1,
	            'day' => 'Sunday',
	            'type' => 'fixed',
	            'start_time' => 1554868800,
	            'end_time' => 1554897600,
	            'time_duration' => NULL,
	            'offDay' => 0,
	            'created_by' => 1,
	        ],
	        [
	            'employee_id' => 1,
	            'day' => 'Monday',
	            'type' => 'offday',
	            'start_time' => NULL,
	            'end_time' => NULL,
	            'time_duration' => NULL,
	            'offDay' => 1,
	            'created_by' => 1,
	        ],
	        [
	            'employee_id' => 1,
	            'day' => 'Tuesday',
	            'type' => 'fixed',
	            'start_time' => 1554868800,
	            'end_time' => 1554897600,
	            'time_duration' => NULL,
	            'offDay' => 0,
	            'created_by' => 1,
	        ],
	        [
	            'employee_id' => 1,
	            'day' => 'Wednessday',
	            'type' => 'fixed',
	            'start_time' => 1554868800,
	            'end_time' => 1554897600,
	            'time_duration' => NULL,
	            'offDay' => 0,
	            'created_by' => 1,
	        ],
	        [
	            'employee_id' => 1,
	            'day' => 'Thursday',
	            'type' => 'fixed',
	            'start_time' => 1554868800,
	            'end_time' => 1554897600,
	            'time_duration' => NULL,
	            'offDay' => 0,
	            'created_by' => 1,
	        ]
		]);
    }
}
