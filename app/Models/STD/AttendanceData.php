<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class AttendanceData extends Model
{
	protected $table = "attendance_datas";
    protected $connection = 'std';

    protected $fillable = ['employee_id', 'comments', 'date', 'time', 'no_of_attendance','department_id', 'department_name', 'batch_id', 'batch_name', 'semester', 'course_id', 'course_name', 'course_code', 'status', 'created_at', 'updated_at'];

    public function getFullDateTimeAttribute()
    {
        return $this->date . ' ' . $this->time;
    }

    public function relAttendanceReport()
    {
        return $this->hasMany('App\Models\STD\AttendanceReport', 'attendance_data_id', 'id');
    }
}
