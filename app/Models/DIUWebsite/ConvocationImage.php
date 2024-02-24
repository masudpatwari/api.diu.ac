<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class ConvocationImage extends Model
{
    protected $table = "convocation_images";

    protected $fillable = [
        'convocation_id',
        'image_url',
    ];

}
