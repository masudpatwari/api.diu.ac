<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('campuses')->insert([
            'name' => "Banani",
            'created_by' => 1,
        ]);
    }
}
