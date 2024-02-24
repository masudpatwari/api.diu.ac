<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class OtherStudentFormConvocationSecondDegree extends Model
{
    protected $table = "other_student_form_convocation_second_degree";
    protected $connection = 'mysql';

    protected $fillable = [
        'other_student_form_id',
        'program',
        'major_in',
        'roll_no',
        'registration_no',
        'batch',
        'session',
        'group',
        'duration_of_the_course',
        'shift',
        'passing_year',
        'result',
        'result_published_date',
    ];

}
