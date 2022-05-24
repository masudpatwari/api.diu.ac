<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $table = "S_DEPARTMENT";
    protected $connection = 'std';

    protected $fillable = [];

    public function relStudent()
    {
        return $this->hasMany('App\Models\STD\Student', 'DEPARTMENT_ID', 'ID');
    }

}
