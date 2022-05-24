<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgram extends Model
{
    protected $table = "website_programs";

    protected $guarded = ['id'];

    public function scopeactive($q)
    {
        return $q->whereStatus('active');
    }

    public function scopeorderPosition($q)
    {
        return $q->orderBy('position');
    }

}
