<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content_meta extends Model
{

    protected $fillable = [
        'name',
        'created_by',
    ];
}
