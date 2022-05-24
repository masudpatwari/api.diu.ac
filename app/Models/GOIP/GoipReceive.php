<?php

namespace App\Models\GOIP;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoipReceive extends Model
{
    use SoftDeletes;

    protected $table = "goip_receives";
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public function scopeOrderDesc($q)
    {
        $q->orderBy('id', 'desc');
    }

}
