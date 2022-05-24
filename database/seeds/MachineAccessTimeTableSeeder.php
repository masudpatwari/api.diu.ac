<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineAccessTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('machineAccessTimes')->insert([
            [
                'att_data_id' => 111111,
                'datetime' => 1553448498,
                'attendanceMachine_id' => 1,
                'day' => 'Sunday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553476915,
                'attendanceMachine_id' => 1,
                'day' => 'Sunday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553706018,
                'attendanceMachine_id' => 1,
                'day' => 'Wednessday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553734855,
                'attendanceMachine_id' => 1,
                'day' => 'Wednessday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553790618,
                'attendanceMachine_id' => 1,
                'day' => 'Thursday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553826115,
                'attendanceMachine_id' => 1,
                'day' => 'Thursday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553873858,
                'attendanceMachine_id' => 1,
                'day' => 'Friday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553907887,
                'attendanceMachine_id' => 1,
                'day' => 'Friday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553963294,
                'attendanceMachine_id' => 1,
                'day' => 'Saturday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
            [
                'att_data_id' => 111111,
                'datetime' => 1553996183,
                'attendanceMachine_id' => 1,
                'day' => 'Saturday',
                'type' => 'fixed',
                'start_time' => 1553965200,
                'end_time' => 1553994000,
                'time_duration' => NULL,
                'offDay' => 0,
                'attendanceDataFile_id' => 1,
                'created_by' => 1
            ],
        ]);
    }
}
