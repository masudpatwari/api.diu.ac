<?php

namespace App\Models\HMS;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $connection = 'hms';

    public $timestamps = false;
}
