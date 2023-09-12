<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = "sliders";

    protected $fillable = [
        'title',
        'apply_url',
        'short_description',
        'status',
        'image_url',
        'created_by',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
