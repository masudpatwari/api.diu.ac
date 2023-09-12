<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeRole extends Model
{

    use SoftDeletes;

    protected $table = "employee_roles";

    use SoftDeletes;

    protected $fillable = [
        'role_id',
        'employee_id',
        'created_by',
    ];

    public function relRole()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }

    public function relDeletedBy()
    {
        return $this->belongsTo('App\Employee', 'deleted_by', 'id');
    }

    public static function isAdmin($employee_id)
    {
        $role = self::with('relRole')->where('employee_id', $employee_id)->first();

        if( $role->relRole->slug=='admin' || $role->relRole->slug == 'su')
        {
            return true;
        }

        else return false;
    }
}
