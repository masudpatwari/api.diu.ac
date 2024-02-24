<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDeny extends Model
{
	protected $table = "taskDenies";
    protected $fillable = [
        'task_id',
        'employee_id',
        'reason',
        'datetime',
        'created_by',
    ];
}
