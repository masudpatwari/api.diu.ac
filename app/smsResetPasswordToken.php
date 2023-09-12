<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class smsResetPasswordToken extends Model
{
    protected $table = "smsResetPasswordToken";

    use SoftDeletes;
    
    protected $fillable = [
        'employee_id',
        'phone_number',
        'token',
        'ip',
        'created_by',
    ];
}
