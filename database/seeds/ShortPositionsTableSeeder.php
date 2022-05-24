<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShortPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('shortPositions')->insert([
            'name' => "BOT",
            'description' => "Board Of Trusty",
            'created_by' => 1,
        ]);
    }
}
