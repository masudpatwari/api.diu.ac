<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = "newsletters";

    protected $fillable = [
        'email',
        'status',
    ];

    public function scopedecending($q)
    {
        return $q->orderByDesc('id');
    }

}
