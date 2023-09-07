<?php

namespace App\Models\Tcrc;


use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $connection = "tcrc";
    protected $table = "settings";

    protected $fillable = [
        'about_diu',
        'about_tcrc',
        'video_id',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class,'video_id');
    }

}
