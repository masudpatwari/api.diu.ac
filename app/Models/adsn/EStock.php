<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;

class EStock extends Model
{
    protected $connection = 'adm';

    protected $table = 'b_stocks';

    protected $guarded = [];

    public $timestamps = false;


}
