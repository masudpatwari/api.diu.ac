<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreviousEmployments extends Model
{
	protected $table = "previousEmployments";
    
    use SoftDeletes;
	
    protected $fillable = [
    	'employee_id',
    	'position',
    	'department',
    	'institute',
    	'from',
    	'to'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
