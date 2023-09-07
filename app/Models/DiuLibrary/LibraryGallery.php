<?php

namespace App\Models\DiuLibrary;

use Illuminate\Database\Eloquent\Model;

class LibraryGallery extends Model
{
    protected $table = "library_galleries";

    protected $fillable = [
        'title',
        'image_url',
        'status',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
