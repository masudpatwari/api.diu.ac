<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $connection = 'adm';

    protected $table = 'imports';

    protected $guarded = [];
    
    public $timestamps = false;


}
