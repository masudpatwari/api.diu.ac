<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class VitalPersonType extends Model
{
    protected $table = "vital_person_types";

    protected $fillable = [
        'title',
        'slug',
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

    public function vitalPersons()
    {
        return $this->hasMany(VitalPerson::class, 'vital_person_type_id')->oldest('rank')->active();
    }

}
