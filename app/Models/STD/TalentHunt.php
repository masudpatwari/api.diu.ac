<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class TalentHunt extends Model
{
    protected $table = "talent_hunts";
    protected $connection = 'std';

    protected $fillable = [
        'student_id',
        'fb_url',
        'phone_number',
        'category',
        'category_item',
        'image_url',
        'video_url',
    ];

    public function scopedsc($q)
    {
        $q->orderBy('id', 'desc');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\STD\Student','student_id','ID');
    }

}
