<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{    
    protected $fillable = [
        'name',
        'taskType_id',
        'location',
        'creator_emp_id',
        'receiver_emp_id',
        'doneby_emp_id',
        'detail',
        'str_datetime',
        'end_datetime',
        'parent_id',
        'priority',
    ];
}
