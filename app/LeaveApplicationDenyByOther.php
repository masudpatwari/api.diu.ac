<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApplicationDenyByOther extends Model
{
	protected $table = "leaveApplicationDenyByOthers";

    protected $fillable = [
        'leaveApplication_id',
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
