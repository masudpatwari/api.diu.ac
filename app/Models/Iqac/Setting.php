<?php

namespace App\Models\Iqac;


use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $connection = "iqac";
    protected $table = "settings";

    protected $fillable = [
        'about_diu',
        'about_tcrc',
        'mission_vision',
        'video_id',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

}
