<?php

namespace App\Models\INTL;

use Illuminate\Database\Eloquent\Model;

class PotentialStudent extends Model
{

	protected $table = "potential_students";
    protected $connection = 'intl';

    protected $guarded = ['id'];

}
