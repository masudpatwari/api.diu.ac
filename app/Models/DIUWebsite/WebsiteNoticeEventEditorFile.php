<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteNoticeEventEditorFile extends Model
{
    protected $table = "website_notice_event_editor_files";

    protected $guarded = [
        'title',
        'file_url',
        'created_by',
    ];

    public function scopedecending($q)
    {
        return $q->orderByDesc('id');
    }

}
