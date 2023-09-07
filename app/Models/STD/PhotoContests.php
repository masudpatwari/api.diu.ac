<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class PhotoContests extends Model
{
    protected $table = "photo_contests";
    protected $connection = 'std';

    public function scopedsc($q)
    {
        $q->orderBy('id', 'desc');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\STD\Student','created_by','ID');
    }


}
