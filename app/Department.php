<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departments";
    protected $connection = 'mysql';
    
    protected $fillable = [
        'name',
        'type',
        'created_by',
        'doc_mtg_code',
    ];

    public function relEmployee()
    {
        return $this->hasMany('App\Employee', 'department_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
