<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgramFacility extends Model
{
    protected $table = "website_program_facilities";

    protected $fillable = [
        'website_program_id',
        'title',
        'description',
        'status',
    ];

}
