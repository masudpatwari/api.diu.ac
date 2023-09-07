<?php

namespace App\Models\Attendance;


use Illuminate\Database\Eloquent\Model;

class AttendenceInfo extends Model
{
    protected $table = "attendance_infos";
    public $timestamps = false;
    protected $connection = 'mysql';

    protected $guarded = ['id'];

    public function absents()
    {
        return $this->hasMany(AbsentStudent::class);
    }
}
