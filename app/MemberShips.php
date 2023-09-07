<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberShips extends Model
{
	protected $table = "memberships";
    
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
