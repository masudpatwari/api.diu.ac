<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{    
    protected $table = "holidays";
    
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'number_of_days',
        'cause',
        'created_by',
    ];

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }

}
