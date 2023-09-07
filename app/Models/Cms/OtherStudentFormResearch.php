<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class OtherStudentFormResearch extends Model
{
    protected $table = "other_student_form_researches";
    protected $connection = 'mysql';

    protected $fillable = [
        'other_student_form_id',
        'title',
        'organization',
        'supervisor',
        'co_supervisor',
        'address',
        'interest_field',
    ];

    protected $casts = [
        'interest_field' => 'array'
    ];

}
