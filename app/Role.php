<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'permissions', 'created_by',
    ];

    public function relEmployeeRole()
    {
        return $this->hasMany('App\EmployeeRole', 'role_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }

    public function relDeletedBy()
    {
        return $this->belongsTo('App\Employee', 'deleted_by', 'id');
    }
}
