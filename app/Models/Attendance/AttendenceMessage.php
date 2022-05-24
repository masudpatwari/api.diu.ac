<?php

namespace App\Models\Attendance;


use Illuminate\Database\Eloquent\Model;

class AttendenceMessage extends Model
{
    protected $table = "attendence_messages";
    public $timestamps = false;
    protected $connection = 'mysql';

    protected $fillable = [
        'schedule',
    ];

    public static function schedule()
    {
        return self::value('schedule');
    }
}
