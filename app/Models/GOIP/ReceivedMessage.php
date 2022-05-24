<?php

namespace App\Models\GOIP;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ReceivedMessage extends Model
{
    protected $table = "receive";
    protected $connection = 'pbxsms';

    public function scopeOrder($q)
    {
        $q->orderBy('id', 'desc');
    }

    public function goip()
    {
        return $this->belongsTo(Goip::class, 'goipid', 'id');
    }

}
