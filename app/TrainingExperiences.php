<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingExperiences extends Model
{
	protected $table = "trainingExperiences";
	
    use SoftDeletes;
    
    protected $fillable = [
    	'employee_id',
    	'title',
    	'duration',
    	'year',
    	'institute'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
