<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgramGallery extends Model
{
    protected $table = "website_program_galleries";

    protected $fillable = [
        'website_program_id',
        'title',
        'image_url',
        'status',
    ];

}
