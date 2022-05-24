<?php

namespace App\Models\Iqac;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $connection = "iqac";
    protected $table = "photos";

    protected $fillable = [
        'title',
        'image_url',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
