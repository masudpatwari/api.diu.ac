<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class AttendanceReport extends Model
{
	protected $table = "attendance_reports";
    protected $connection = 'std';

    protected $fillable = ['attendance_data_id', 'student_id', 'created_at','updated_at'];

    public function relAttendanceData()
    {
        return $this->belongsTo('App\Models\STD\AttendanceData', 'attendance_data_id', 'id');
    }
    
    public function relStudent()
    {
        return $this->belongsTo('App\Models\STD\relStudent', 'student_id', 'id');
    }
}
