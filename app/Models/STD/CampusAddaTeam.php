<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class CampusAddaTeam extends Model
{
	protected $table = "campus_adda_teams";
    protected $connection = 'std';

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'ID');
    }

}
