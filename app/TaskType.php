<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
	protected $table = "taskTypes";
    protected $fillable = [
        'name',
        'created_by',
    ];
}
