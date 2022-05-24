<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WiFiWithMac extends Model
{
	protected $table = "WiFiWithMac";
	protected $timestamp = true;

    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'mac_address',
    ];

}
