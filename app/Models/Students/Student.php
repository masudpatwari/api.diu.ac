<?php

namespace App\Models\Students;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
   
	protected $connection = "students";
	protected $table = "student";

    public $timestamps = false;

    protected $guarded = [];
}
