<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $table = "email_campaigns";
    protected $connection = 'intl';

    protected $fillable = [
        'name',
        'message',
        'count_email_account',
        'created_by',
    ];

}
