<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwitchOffDay extends Model
{
	protected $table = "switchOffDays";
	public $timestamps = true;

    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'offdayDate',
        'changeToDate',
				'supervisor_id',
    ];

    public function relSupervisorEmployee()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id', 'id');
    }
    public function relCreatedByEmployee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function relDeletedByEmployee()
    {
        return $this->belongsTo(Employee::class, 'deleted_by', 'id');
    }
}
