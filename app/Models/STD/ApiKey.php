<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
	protected $table = "apiKeys";
    protected $connection = 'std';

    use SoftDeletes;
	
    protected $fillable = [
        'student_id',
        'apiKey',
        'lastAccessTime',
    ];

    public function relEmployee()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
