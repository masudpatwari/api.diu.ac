<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class CampusAdda extends Model
{
	protected $table = "campus_addas";
    protected $connection = 'std';

    public function campus_adda_teams()
    {
        return $this->hasMany(CampusAddaTeam::class, 'campus_adda_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'created_by', 'ID');
    }

}
