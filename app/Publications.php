<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publications extends Model
{
	protected $table = "publications";
    
    use SoftDeletes;
	
    protected $fillable = [
    	'employee_id',
    	'type',
    	'description'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
