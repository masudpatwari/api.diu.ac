<?php

namespace App\Models\Students;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class SmsSchedule extends Model
{
   
	protected $connection = "students";
	protected $table = "sms_schedule";

    public $timestamps = false;

    protected $guarded = [];
}
