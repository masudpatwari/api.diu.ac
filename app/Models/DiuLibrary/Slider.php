<?php

namespace App\Models\DiuLibrary;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = "library_sliders";

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'status',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
