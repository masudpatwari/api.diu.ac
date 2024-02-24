<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskWithdraw extends Model
{
	protected $table = "taskWithdraws";
    protected $fillable = [
        'task_id',
        'reason',
        'datetime',
        'created_by',
    ];
}
