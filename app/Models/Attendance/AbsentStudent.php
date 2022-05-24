<?php

namespace App\Models\Attendance;


use Illuminate\Database\Eloquent\Model;

class AbsentStudent extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';

    protected $guarded = ['id'];


}
