<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpartOn extends Model
{
	protected $table = "expartOn";
    
    use SoftDeletes;
	
    protected $fillable = [
    	'employee_id',
    	'title'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
