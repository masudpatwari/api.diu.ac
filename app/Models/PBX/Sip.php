<?php

namespace App\Models\PBX;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Sip extends Model
{
    protected $table = "sip";
    protected $connection = 'pbx';

}
