<?php

namespace App\Models\DiuLibrary;

use Illuminate\Database\Eloquent\Model;

class LibraryContactForm extends Model
{
    protected $table = "library_contact_forms";

    protected $fillable = [
        'name',
        'subject',
        'email',
        'message',
        'status',
    ];

}
