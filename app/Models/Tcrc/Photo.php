<?php

namespace App\Models\Tcrc;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $connection = "tcrc";
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
