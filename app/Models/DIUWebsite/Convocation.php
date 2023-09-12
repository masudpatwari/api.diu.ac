<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
    protected $table = "convocations";

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'status',
        'created_by',
    ];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

    public function scopedecending($q)
    {
        return $q->orderByDesc('id');
    }

    public function convoctionImages()
    {
        return $this->hasMany(ConvocationImage::class,'convocation_id');
    }

}
