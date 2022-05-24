<?php

namespace App\Models\INTL;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;


class StudentMedia extends Model
{
	protected $table = "student_media";

    protected $connection = 'intl';

    protected $fillable = [
        'user_id',
        'title',
        'filename',
        'extension',
    ];
    
}
