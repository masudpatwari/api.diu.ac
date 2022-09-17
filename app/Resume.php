<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
	protected $connection = "students";
	protected $table = "resumes";
    protected $appends = ['age'];

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'resume',
        'date',
        'image',
        'qualifications',
        'dob',
        'status',
        'gender',
        'a_status',
        'file',
    ];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['dob'])->age;
    }
}
