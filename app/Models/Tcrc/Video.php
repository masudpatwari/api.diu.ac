<?php

namespace App\Models\Tcrc;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $connection = "tcrc";
    protected $table = "videos";

    protected $fillable = [
        'title',
        'code',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
