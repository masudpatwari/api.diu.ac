<?php

namespace App\Models\Iqac;


use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $connection = "iqac";
    protected $table = "teams";

    protected $fillable = [
        'type',
        'employee_id',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class,'created_by');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

}
