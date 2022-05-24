<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryContent extends Model
{

    protected $fillable = [
        'name',
        'created_by',
    ];
}
