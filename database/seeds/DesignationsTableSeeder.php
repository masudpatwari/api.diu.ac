<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('designations')->insert([
            'name' => "Chairman",
            'type' => "academic",
            'created_by' => 1,
        ]);
    }
}
