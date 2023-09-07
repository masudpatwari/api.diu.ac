<?php

namespace App\Models\DiuLibrary;

use Illuminate\Database\Eloquent\Model;

class LibraryDocument extends Model
{
    protected $table = "library_documents";

    protected $fillable = [
        'title',
        'file_url',
        'status',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
