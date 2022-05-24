<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class TeacherServiceFeedbackDetail extends Model
{
    protected $table = "teacher_service_feedback_details";
    protected $connection = 'std';

    public function category()
    {
        return $this->belongsTo(TeacherServiceCategory::class, 'teacher_service_category_id');
    }

}
