<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class LectureSheet extends Model
{
	protected $table = "lecture_sheets";
    protected $connection = 'std';

    protected $fillable = [
    	'course_name', 'course_code', 'department', 'semester', 'published', 'session', 'prepared_by', 'submission_date', 'created_by'
    ];

}
