<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgramFaculty extends Model
{
    protected $table = "website_program_faculties";

    protected $fillable = [
        'website_program_id',
        'short_position_ids',
    ];

    protected $casts = [
        'short_position_ids' => 'array'
    ];

}
