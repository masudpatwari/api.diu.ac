<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;

class FormDetails extends Model
{
    protected $connection = 'adm';

    protected $table = 'details';

    protected $guarded = [];

    public $timestamps = false;
}
