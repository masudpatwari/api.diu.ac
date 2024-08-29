<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Model;

class CourseCalculationProgramFee extends Model
{
    protected $table = "course_calculation_program_fees";

    protected $fillable = [
        'name',
        'type',
        'shift',
        'course_fee',
        'admission_fee',
        'status',
        'social_link',
    ];

    protected $appends = ['program_name'];

    public function scopeactive($q)
    {
        return $q->whereStatus(true);
    }

    public function getProgramNameAttribute()
    {
        if ($this->shift) {
            return $this->name . ' (' . ($this->shift) . ')';
        }
        return $this->name;

    }

}
