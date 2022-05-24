<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $table = "diuac_publications";

    protected $fillable = [
        'title',
        'status',
        'image_url',
        'created_by',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
