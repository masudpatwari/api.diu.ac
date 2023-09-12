<?php

namespace App\Models\HMS;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $connection = 'hostel';

    public $timestamps = false;      
    
    protected $guarded = ['id'];
 

    public function hostel()
    {
    	return $this->belongsTo(Hostel::class, 'hostel_id');
    }
     
    public function room()
    {
    	return $this->belongsTo(Room::class, 'room_id');
    }
}
