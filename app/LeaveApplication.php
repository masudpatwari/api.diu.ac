<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $table = "leaveApplications";
    
    protected $fillable = [
        'employee_id',
        'status',
        'pending_in_employee_id',
        'cause',
        'need_permission',
        'accept_salary_difference',
        'alt_employee',
        'alt_employee_approved'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

    public function relPendingInEmployee()
    {
        return $this->belongsTo('App\Employee', 'pending_in_employee_id', 'id');
    }

    public function relLeaveApplicationHistory()
    {
        return $this->hasMany('App\LeaveApplicationHistory', 'leaveApplication_id', 'id');
    }

    public function relLeaveApplicationHistorySingle()
    {
        return $this->hasOne('App\LeaveApplicationHistory', 'leaveApplication_id', 'id');
    }

    public function relleaveApplicationComment()
    {
        return $this->hasMany('App\LeaveApplicationComment', 'leaveApplication_id', 'id');
    }

    public function relleaveApplicationDenyByOther()
    {
        return $this->hasOne('App\LeaveApplicationDenyByOther', 'leaveApplication_id', 'id');
    }
}
