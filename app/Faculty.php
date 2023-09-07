<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{    
    protected $fillable = [
        'name',
        'short_name',
        'description',
        'created_by',
    ];

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }

    public function relPrograms()
    {
        return $this->hasMany('App\Program', 'faculty_id', 'id')->whereStatus('active')->orderBy('type');
    }
}
