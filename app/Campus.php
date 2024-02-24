<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
	protected $table = "campuses";

    protected $fillable = [
        'name',
        'created_by',
    ];

    public function relEmployee()
    {
        return $this->hasMany('App\Employee', 'campus_id', 'id');
    }
}
