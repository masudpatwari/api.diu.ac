<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceId extends Model
{
    protected $table = "attendanceIds";

    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'att_data_id',
        'att_card_id',
        'created_by',
    ];

    public function relmachineAccessTime()
    {
        return $this->hasMany('App\MachineAccessTime', 'att_data_id', 'att_data_id');
    }

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }

    public function relDeletedBy()
    {
        return $this->belongsTo('App\Employee', 'deleted_by', 'id');
    }
}
