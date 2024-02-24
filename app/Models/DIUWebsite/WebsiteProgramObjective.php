<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgramObjective extends Model
{
    protected $table = "website_program_objectives";

    protected $fillable = [
        'website_program_id',
        'title',
        'description',
        'status',
    ];

}
