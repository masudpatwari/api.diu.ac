<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineAccessTime extends Model
{
    protected $table = "machineAccessTimes";

    protected $fillable = [
        'att_data_id',
        'datetime',
        'attendanceMachine_id',
        'day',
        'type',
        'start_time',
        'end_time',
        'time_duration',
        'offDay',
        'attendanceDataFile_id',
        'created_by'
    ];

    public function relAttendanceId()
    {
        return $this->belongsTo('App\AttendanceId', 'att_data_id', 'att_data_id');
    }

    public function relattendanceDataFile()
    {
        return $this->belongsTo('App\AttendanceDataFile', 'attendanceDataFile_id', 'id');
    }

    public function relattendanceMachine()
    {
        return $this->belongsTo('App\AttendanceMachine', 'attendanceMachine_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
