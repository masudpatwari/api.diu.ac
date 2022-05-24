<?php

namespace App\Models\DIUWebsite;

use App\Libraries\Slug;
use Illuminate\Database\Eloquent\Model;

class WebsiteNoticeEvent extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'slug',
        'status',
        'created_by',
    ];

    protected $table = "website_notice_event";

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

    public function scopedecending($q)
    {
        return $q->orderByDesc('id');
    }

    public function noticeFiles()
    {
        return $this->hasMany(WebsiteNoticeEventFile::class, 'website_notice_event_id');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Slug::makeSlug($value);
    }

}
