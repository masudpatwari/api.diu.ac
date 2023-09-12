<?php

namespace App\Models\STD;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class StaffsServiceInfoFeedbacks extends Model
{
    protected $table = "staffs_service_info_feedbacks";
    protected $connection = 'std';

    protected $fillable = [
        'staff_service_feedback_id',
        'employee_id',
    ];


    public function staffServiceInfoFeedbackDetails()
    {
        return $this->hasMany(StaffsServiceInfoFeedbackDetails::class, 'staffs_service_info_feedback_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function staffServiceFeedback()
    {
        return $this->belongsTo(StaffServiceFeedback::class, 'staff_service_feedback_id');
    }

}
