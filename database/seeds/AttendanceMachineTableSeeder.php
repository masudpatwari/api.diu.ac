<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceMachineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('attendanceMachines')->insert([
            'location' => 'Banani',
            'datetime' => time(),
            'created_by' => 1,
        ]);
    }
}
