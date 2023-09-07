<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeUpdateHistory extends Model
{
    protected $table = "employeeUpdateHistories";
    
    protected $fillable = [
        'employee_id',
        'prev_row',
        'created_by',
    ];
}
