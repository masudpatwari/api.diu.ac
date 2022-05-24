<?php

namespace App\Models\Tcrc;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $connection = "tcrc";
    protected $table = "partners";

    protected $fillable = [
        'title',
        'url',
        'image_path',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class,'created_by');
    }

}
