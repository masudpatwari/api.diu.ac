<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $table = "questions";
    protected $connection = 'std';

    protected $fillable = [
    	'course_name', 'course_code', 'department', 'semester', 'published', 'session', 'description'
    ];

}
