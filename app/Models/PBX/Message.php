<?php

namespace App\Models\PBX;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PBX\Sends;

class Message extends Model
{
	protected $table = "message";

    protected $connection = 'pbx';

    protected $dates = [
    ];

    protected $fillable = [
    ];


    public function relMobileNumber()
    {
        return $this->hasMany(Sends::class, 'student_id', 'student_id');
    }
    
}
