<?php

namespace App\Models\HMS;

use App\Models\HMS\Hostel;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $connection = 'hms';
    
    protected $guarded = ['id'];

    public $timestamps = false;
    
    public function hostel()
    {
    	return $this->belongsTo(Hostel::class, 'hostel_id');
    }
}
