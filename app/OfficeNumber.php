<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OfficeNumber extends Model
{
	protected $connection = "students";
	protected $table = "office_number";    

    public $timestamps = false;

    protected $fillable = [      
        'phone',
       
    ];

    
}
