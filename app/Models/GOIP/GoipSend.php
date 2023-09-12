<?php

namespace App\Models\GOIP;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoipSend extends Model
{
    use SoftDeletes;

    protected $table = "goip_sends";
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public function scopeOrderDesc($q)
    {
        $q->orderBy('id', 'desc');
    }

}
