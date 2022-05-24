<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radcheck extends Model
{
	protected $table = "radcheck";
    protected $connection = 'pfsense';
	public $timestamps = false;

    protected $fillable = [
        'username',
        'value',
        'identification',
    ];

}
