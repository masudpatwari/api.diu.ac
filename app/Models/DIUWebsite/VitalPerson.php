<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class VitalPerson extends Model
{
    protected $table = "vital_persons";

    protected $fillable = [
        'vital_person_type_id',
        'name',
        'title',
        'description',
        'image_url',
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

    public function scopetypeAcending($q)
    {
        return $q->orderBy('vital_person_type_id','asc');
    }

    public function vitalPersonType()
    {
        return $this->belongsTo(VitalPersonType::class,'vital_person_type_id');
    }

}
