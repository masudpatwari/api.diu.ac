<?php

namespace App\Models\SwitchControl;

use Illuminate\Database\Eloquent\Model;

class RelayIpChannel extends Model
{
	protected $table = "relay_ip_channels";
    protected $connection = 'mysql';
	
    protected $fillable = [
        'relay_ip_id',
        'channel_number',
        'channel_name',
        'channel_port',
    ];
}
