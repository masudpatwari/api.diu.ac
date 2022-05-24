<?php

namespace App\Models\Iqac;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $connection = "iqac";
    protected $table = "sliders";

    protected $fillable = [
        'title',
        'short_description',
        'image_path',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class,'created_by');
    }

}
