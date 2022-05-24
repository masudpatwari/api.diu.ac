<?php

namespace App\Models\HMS;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $connection = 'hms';
    
    protected $guarded = ['id'];

    public $timestamps = false;
}
