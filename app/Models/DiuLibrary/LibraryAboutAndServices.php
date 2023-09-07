<?php

namespace App\Models\DiuLibrary;

use Illuminate\Database\Eloquent\Model;

class LibraryAboutAndServices extends Model
{
    protected $table = "library_about_and_services";

    protected $fillable = [
        'type',
        'title',
        'description',
        'status',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
