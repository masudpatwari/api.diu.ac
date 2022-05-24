<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteContactForm extends Model
{
    protected $table = "website_contact_forms";

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'subject',
        'message',
        'status',
    ];

    public function scopedecending($q)
    {
        return $q->orderByDesc('id');
    }

}
