<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskHold extends Model
{
	protected $table = "taskHolds";
    protected $fillable = [
        'task_id',
        'employee_id',
        'reason',
        'datetime',
        'created_by',
    ];
}
