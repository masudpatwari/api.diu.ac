<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'faculty_id',
        'department_id',
        'name',
        'status',
        'short_name',
        'description',
        'duration',
        'credit',
        'semester',
        'tuition_fee',
        'admission_fee',
        'total_fee',
        'shift',
        'type',
        'created_by',
    ];

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }

    public function relDepartment()
    {
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }

    public function relFaculty()
    {
        return $this->belongsTo('App\Faculty', 'faculty_id', 'id');
    }

    public static function show($id)
    {
        $programDetails = self::find($id);
        return $programDetails;
    }

    public function scopeactive($q)
    {
        $q->whereStatus('active');
    }
}
