<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;

class AlumniUser extends Model
{
    protected $connection = 'almni';

    protected $table = 'users';

    protected $guarded = [];

    public $timestamps = false;
}
