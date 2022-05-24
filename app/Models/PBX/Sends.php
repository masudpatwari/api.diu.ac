<?php

namespace App\Models\PBX;

use App\Models\GOIP\Provider;
use Illuminate\Database\Eloquent\Model;


class Sends extends Model
{
	protected $table = "sends";
    protected $connection = 'pbxsms';

    protected $dates = [
    ];

    protected $fillable = [
    ];


    public function relForeignStudent()
    {
        return $this->hasMany(ForeignStudent::class, 'student_id', 'student_id');
    }

    public function providers()
    {
        return $this->belongsTo(Provider::class, 'provider', 'id');
    }

}
