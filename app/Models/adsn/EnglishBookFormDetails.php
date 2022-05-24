<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;

class EnglishBookFormDetails extends Model
{
    protected $connection = 'adm';

    protected $table = 'b_details';

    protected $guarded = [];

    public $timestamps = false;
}
