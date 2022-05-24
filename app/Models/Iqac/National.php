<?php

namespace App\Models\Iqac;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class National extends Model
{
    protected $connection = "iqac";
    protected $table = "nationals";

    protected $fillable = [
        'type',
        'title',
        'url',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
