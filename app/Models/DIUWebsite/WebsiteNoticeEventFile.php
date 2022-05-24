<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteNoticeEventFile extends Model
{
    protected $table = "website_notice_event_files";

    protected $guarded = [
        'website_notice_id',
        'file_url',
        'file_name',
    ];

}
