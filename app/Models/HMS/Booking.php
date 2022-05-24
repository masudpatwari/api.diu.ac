<?php

namespace App\Models\HMS;

use Illuminate\Database\Eloquent\Model;
use App\Models\STD\Student;


class Booking extends Model
{
    protected $connection = 'hms';

        
    public function student()
    {
    	return $this->setConnection('std')->belongsTo(Student::class, 'student_id', 'id');
    }

    public $timestamps = false;
}
