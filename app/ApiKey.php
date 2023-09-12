<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
	protected $table = "apiKeys";

    use SoftDeletes;
	
    protected $fillable = [
        'employee_id',
        'apiKey',
        'lastAccessTime',
    ];

    public function relEmployee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
