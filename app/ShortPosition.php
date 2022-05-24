<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortPosition extends Model
{
    protected $table = "shortPositions";
    
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    public function relEmployee()
    {
        return $this->hasMany('App\Employee', 'shortPosition_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
