<?php

namespace App\Models\Iqac;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class NewsActivities extends Model
{
    protected $connection = "iqac";
    protected $table = "news_activities";

    protected $fillable = [
        'type',
        'title',
        'slug',
        'description',
        'image_path',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
