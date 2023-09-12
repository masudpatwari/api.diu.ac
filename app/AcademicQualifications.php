<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicQualifications extends Model
{
	protected $table = "academicQualifications";
    
    use SoftDeletes;
	
    protected $fillable = [
    	'employee_id',
    	'title',
    	'major',
    	'year',
    	'institute'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
