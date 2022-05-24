<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgramIeb extends Model
{
    protected $table = "website_program_ieb";

    protected $fillable = [
        'website_program_id',
        'title',
        'description',
        'youtube_url',
        'status',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
