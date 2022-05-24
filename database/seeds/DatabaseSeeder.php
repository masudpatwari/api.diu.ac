<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call('DepartmentsTableSeeder');
    	$this->call('DesignationsTableSeeder');
    	$this->call('ShortPositionsTableSeeder');
    	$this->call('CampusesTableSeeder');
        $this->call('AttendanceMachineTableSeeder');
        $this->call('MachineAccessTimeTableSeeder');
        $this->call('EmployeesTableSeeder');
        $this->call('AttendanceIdsTableSeeder');
        $this->call('OfficeTimeTableSeeder');
    	$this->call('SystemSettingsTableSeeder');
    }
}
