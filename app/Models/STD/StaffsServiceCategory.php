<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class StaffsServiceCategory extends Model
{
    protected $table = "staffs_service_categories";
    protected $connection = 'std';

    protected $fillable=[
        'title',
        'english_title',
        'status',
        'point',
    ];

}
