<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class StaffServiceFeedback extends Model
{
    protected $table = "staff_service_feedbacks";
    protected $connection = 'std';

    protected $fillable = [
        'student_id',
        'semester',
        'employee_department_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'ID');
    }

    public function department()
    {
        return $this->belongsTo(\App\Department::class, 'employee_department_id');
    }

    public function staffServiceInfoFeedbacks()
    {
        return $this->hasMany(StaffsServiceInfoFeedbacks::class, 'staff_service_feedback_id');
    }

}
