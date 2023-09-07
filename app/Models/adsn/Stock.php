<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $connection = 'adm';

    protected $table = 'stocks';

    protected $guarded = [];

    public $timestamps = false;


}
