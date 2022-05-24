<?php

namespace App\Models\PBX;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class User extends Model
{
    protected $table = "users";
    protected $connection = 'pbx';

    protected $hidden = ['password'];

    public function sip()
    {
        return $this->belongsTo('App\Models\PBX\Sip', 'extension', 'id')->where('keyword', 'secret');
    }

}
