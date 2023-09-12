<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class OtherStudentFormMidTermRetake extends Model
{
    protected $table = "other_student_form_mid_term_retake";
    protected $connection = 'mysql';

    protected $fillable = [
        'other_student_form_id',
        'course_code',
        'course_name',
    ];

}
