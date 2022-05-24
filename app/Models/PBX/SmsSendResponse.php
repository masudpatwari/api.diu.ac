<?php

namespace App\Models\PBX;

use App\Models\GOIP\GoipSend;
use Illuminate\Database\Eloquent\Model;

class SmsSendResponse extends Model
{

	protected $table = "pbx_sms_send_response";

    // protected $connection = 'pbx';

    protected $dates = [
    ];

    protected $fillable = [
    ];

    public function send()
    {
        return $this->belongsTo(GoipSend::class,'taskId','messageid');
    }

}
