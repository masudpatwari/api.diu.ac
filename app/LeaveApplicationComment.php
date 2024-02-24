<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApplicationComment extends Model
{
	protected $table = "leaveApplicationComments";

    protected $fillable = [
        'leaveApplication_id',
        'comment',
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
