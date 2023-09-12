<?php

namespace App\Models\STD;

use App\Models\RMS\WpEmpRms;
use Illuminate\Database\Eloquent\Model;

class TeacherServiceFeedback extends Model
{
    protected $table = "teacher_service_feedbacks";
    protected $connection = 'std';

    protected $fillable = [
        'student_id',
        'semester',
        'course_id',
        'course_code',
        'course_name',
        'teacher_id',
        'teacher_name',
        'teacher_position',
        'skill_increase',
        'other_comments',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'ID');
    }

    public function teacherServiceFeedbackDetails()
    {
        return $this->hasMany(TeacherServiceFeedbackDetail::class, 'teacher_service_feedback_id');
    }


    public function teacher()
    {
        return $this->belongsTo(WpEmpRms::class, 'teacher_id');
    }

}
