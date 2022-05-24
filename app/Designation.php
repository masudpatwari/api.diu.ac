<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = "designations";

    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

    public function relEmployee()
    {
        return $this->hasMany('App\Employee', 'designation_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
