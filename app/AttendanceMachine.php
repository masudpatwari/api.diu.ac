<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceMachine extends Model
{
	protected $table = "attendanceMachines";
	
    protected $fillable = [
        'location',
        'datetime',
        'created_by',
    ];

    public function relMachineAccessTime()
    {
        return $this->hasMany('App\MachineAccessTime', 'attendanceMachine_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
