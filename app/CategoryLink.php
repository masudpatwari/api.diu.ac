<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryLink extends Model
{

    protected $fillable = [
        'name',
        'created_by',
    ];
}
