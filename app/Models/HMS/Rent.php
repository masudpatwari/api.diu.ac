<?php

namespace App\Models\HMS;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $connection = 'hostel';

    public $timestamps = false;
    
    protected $guarded = ['id'];
}
