<?php

namespace App\Models\DIUWebsite;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = "partners";

    protected $fillable = [
        'title',
        'status',
        'image_url',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

}
