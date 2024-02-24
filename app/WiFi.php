<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WiFi extends Model
{
	protected $table = "WiFi";
	protected $timestamp = true;

    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'username',
        'userpassword',
    ];

}
