<?php

namespace App\Models\HMS;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $connection = 'hms';

    public $timestamps = false;
}
