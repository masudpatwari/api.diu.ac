<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Model;

class EmailCampaignDetail extends Model
{
    protected $table = "email_campaign_details";
    protected $connection = 'intl';

    protected $fillable = [
        'email_campaign_id',
        'from_email',
        'subject',
        'to_email',
        'message',
        'available_at',
        'created_by',
    ];

}
