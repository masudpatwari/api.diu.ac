<?php

namespace App\Models\GOIP;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Goip extends Model
{
    protected $table = "goip";
    protected $connection = 'pbxsms';

    protected $fillable = ['gsm_status'];
    public $timestamps = false;

    public function providers()
    {
        return $this->belongsTo(Provider::class, 'provider', 'id');
    }


}
