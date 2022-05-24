<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
	protected $table = "syllabus";
    protected $connection = 'std';

    protected $fillable = [
    	'name', 'department', 'published', 'description', 'short_description', 'feature'
    ];

}
