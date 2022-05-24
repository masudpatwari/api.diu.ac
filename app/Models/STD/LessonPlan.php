<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
	protected $table = "lesson_plans";
    protected $connection = 'std';

    protected $fillable = [
    	'course_name', 'course_code', 'department', 'semester', 'published', 'session', 'prepared_by', 'submission_date', 'created_by'
    ];

}
