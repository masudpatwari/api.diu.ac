<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Model;

class EmailCampaignBcc extends Model
{
    protected $table = "email_campaign_bcc";
    protected $connection = 'intl';

    protected $fillable = [
        'email_campaign_detail_id',
        'email',
    ];

}
