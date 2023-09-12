<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $connection = 'exam';

    protected $fillable = ['per_ques_time'];

    public $timestamps = false;
}
