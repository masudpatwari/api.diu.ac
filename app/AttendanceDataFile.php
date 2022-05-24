<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceDataFile extends Model
{    
    protected $table = "attendanceDataFiles";

    protected $fillable = [
        'filename',
        'datetime',
        'upload_type',
        'created_by',
    ];

    public function relMachineAccessTime()
    {
        return $this->hasMany('App\MachineAccessTime', 'attendanceDataFile_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
