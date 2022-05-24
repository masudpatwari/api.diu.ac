<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgramSyllabus extends Model
{
    protected $table = "website_program_syllabus";

    protected $fillable = [
        'website_program_id',
        'title',
        'description',
        'status',
    ];

}
