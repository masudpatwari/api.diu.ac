<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialContact extends Model
{
	protected $table = "socialContacts";
    
    use SoftDeletes;
	
    protected $fillable = [
    	'employee_id',
        'name',
    	'url'
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
