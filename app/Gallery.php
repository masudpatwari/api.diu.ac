<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = "galleries";

    protected $fillable = [
        'title',
        'employee_id',
        'img_file',
        'created_by',
    ];

    public function relEmployee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }
}
