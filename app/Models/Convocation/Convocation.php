<?php

namespace App\Models\Convocation;

use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
    protected $connection = 'convocation';

    protected $table = "users";

    protected $fillable = [
        'otp',
        'name',
        'convocation_id',
        'timeout'
    ];
}
