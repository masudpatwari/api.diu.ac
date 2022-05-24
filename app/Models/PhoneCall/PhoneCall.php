<?php

namespace App\Models\PhoneCall;

use Illuminate\Database\Eloquent\Model;

class PhoneCall extends Model
{
    protected $fillable = [
        'mobile_number',
        'response',
        'call_time',
        'call_duration',
        'dial_at'
    ];
}
