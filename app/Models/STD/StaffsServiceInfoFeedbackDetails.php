<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class StaffsServiceInfoFeedbackDetails extends Model
{
    protected $table = "staffs_service_info_feedback_details";
    protected $connection = 'std';

    protected $fillable = [
        'staffs_service_info_feedback_id',
        'staffs_service_category_id',
        'point',
    ];

    public function category()
    {
        return $this->belongsTo(StaffsServiceCategory::class, 'staffs_service_category_id');
    }

}
