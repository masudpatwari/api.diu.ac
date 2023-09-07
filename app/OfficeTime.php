<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeTime extends Model
{
    protected $table = "officeTimes";

    use SoftDeletes;
    
    protected $fillable = [
        'employee_id',
        'day',
        'type',
        'start_time',
        'end_time',
        'time_duration',
        'offDay',
        'created_by'
    ];

    public function relOfficeTimeHistory()
    {
        return $this->hasMany('App\OfficeTimeHistory', 'officeTime_id', 'id');
    }

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}