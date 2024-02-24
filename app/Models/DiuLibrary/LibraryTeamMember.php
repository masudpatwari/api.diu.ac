<?php

namespace App\Models\DiuLibrary;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class LibraryTeamMember extends Model
{
    protected $table = "library_team_members";

    protected $fillable = [
        'employee_id',
        'serial_no',
    ];

    public function scopeserialNo($q)
    {
        return $q->orderBy('serial_no');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

}
