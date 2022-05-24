<?php

namespace App\Models\GOIP;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = "prov";
    protected $connection = 'pbxsms';


}
