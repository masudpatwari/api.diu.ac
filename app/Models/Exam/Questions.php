<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $connection = 'exam';

    protected $guarded = ['id'];

    public $timestamps = false;
}
