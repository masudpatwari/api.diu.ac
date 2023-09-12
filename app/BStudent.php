<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BStudent extends Model
{
	protected $connection = "students";
	protected $table = "blocked_students";

    public $timestamps = false;


    protected $fillable = [
        'name',
        'department',
        'batch',
        'roll',
        'fb_link',
        'problem',
        'entry_date',
        'photo',
        'entry_by',
        'department_id',
        'batch_id',
        'student_id',
        'image_link'
    ];
}
