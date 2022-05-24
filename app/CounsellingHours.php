<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounsellingHours extends Model
{
	protected $table = "counsellingHours";
    
    use SoftDeletes;
	
    protected $fillable = [
    	'employee_id',
    	'day',
    	'time_from',
    	'time_to',
    	'place'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
