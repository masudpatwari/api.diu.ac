<?php

namespace App\Models\DiuLibrary;

use Illuminate\Database\Eloquent\Model;

class LibraryHome extends Model
{
    protected $table = "library_home";

    protected $fillable = [
        'about',
        'mission',
        'vision',
        'library_hours',
        'printed_books',
        'printed_journals',
        'online_e_books',
        'online_journals',
        'image_url',
    ];

}
