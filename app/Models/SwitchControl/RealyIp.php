<?php

namespace App\Models\SwitchControl;

use Illuminate\Database\Eloquent\Model;

class RealyIp extends Model
{
    protected $table = "relay_ips";
    protected $connection = 'mysql';

    protected $fillable = [
        'ip_address',
        'status',
        'created_by',
    ];

    public function realyIpDetails()
    {
        return $this->hasMany(RelayIpChannel::class, 'relay_ip_id');
    }
}
