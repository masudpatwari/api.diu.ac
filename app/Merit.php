<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merit extends Model
{    
    protected $fillable = [
        'value',
        'created_by',
    ];
}
