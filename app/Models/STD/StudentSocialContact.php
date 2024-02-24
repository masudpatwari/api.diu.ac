<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class StudentSocialContact extends Model
{
	protected $table = "student_social_contacts";
    protected $connection = 'std';

    protected $fillable = [
    	'student_id', 'name', 'link'
    ];

}
