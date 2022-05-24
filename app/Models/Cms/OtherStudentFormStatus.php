<?php

namespace App\Models\Cms;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class OtherStudentFormStatus extends Model
{
    protected $table = "other_student_form_status";

    protected $fillable = [
        'other_student_form_id',
        'employee_id',
        'verified_status',
        'type',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }


}
