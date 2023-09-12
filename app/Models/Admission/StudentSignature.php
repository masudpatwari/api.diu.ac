<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Model;

class StudentSignature extends Model
{
    protected $table = "student_signatures";
    protected $connection = 'std';

    protected $fillable = [
        'student_oracle_id',
        'file_path',
    ];
}
