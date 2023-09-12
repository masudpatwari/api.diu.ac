<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentLink extends Model
{

    protected $fillable = [
        'name',
        'created_by',
    ];
}
