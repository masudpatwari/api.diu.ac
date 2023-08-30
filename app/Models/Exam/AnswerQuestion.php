<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class AnswerQuestion extends Model
{
    protected $connection = 'exam';

    protected $table = 'question_answers';

    protected $guarded = ['id'];
}
