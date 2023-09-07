<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class StudentEducation extends Model
{
	protected $table = "student_educations";
    protected $connection = 'std';

    protected $fillable = [
    	'student_id', 'certificate_name', 'institute_name', 'is_still_here', 'passing_year', 'result'
    ];

}
