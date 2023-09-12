<?php

namespace App\Models\Convocation;

use Illuminate\Database\Eloquent\Model;

class StudentConvocation extends Model
{
    protected $table = "student_convocations";

    protected $fillable = [
        'number_of_convocation',
        'form_number',
        'image_url',
        'student_name',
        'father_name',
        'mother_name',
        'present_address',
        'permanent_address',
        'nationality',
        'contact_no',
        'email_address',
        'name_of_program_one',
        'major_in_one',
        'roll_no_one',
        'reg_code_one',
        'batch_one',
        'session_one',
        'group_one',
        'duration_of_the_courses_one',
        'shift_one',
        'passing_year_one',
        'result_one',
        'result_published_date_one',
        'second_degree',
        'name_of_program_two',
        'major_in_two',
        'roll_no_two',
        'reg_code_two',
        'batch_two',
        'session_two',
        'group_two',
        'duration_of_the_courses_two',
        'shift_two',
        'passing_year_two',
        'result_two',
        'result_published_date_two',
        'created_by',
        'confirmed',
        'serial'
    ];

    public function scopeorder($q)
    {
        return $q->orderBy('form_number');
    }
}
