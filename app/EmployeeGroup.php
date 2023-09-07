<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeGroup extends Model
{
	protected $table = "employee_groups";
	
    protected $fillable = [
    	'name', 'slug_name'
    ];
}
