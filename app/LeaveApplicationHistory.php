<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApplicationHistory extends Model
{
	protected $table = "leaveApplicationHistories";

    use SoftDeletes;
	
    protected $fillable = [
        'leaveApplication_id',
        'kindofleave',
        'start_date',
        'end_date',
        'number_of_days',
        'created_by',
    ];

    public function relLeaveApplication()
    {
        return $this->belongsTo('App\LeaveApplication', 'leaveApplication_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
