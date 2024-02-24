<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('system_settings')->insert([
            'key' => "session_expired_time",
            'value' => 36000,
            'created_by' => 1,
        ]);
    }
}
