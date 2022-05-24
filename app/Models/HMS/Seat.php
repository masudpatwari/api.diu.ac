<?php

namespace App\Models\HMS;
use App\Models\HMS\Room;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $connection = 'hms';

    public $timestamps = false;      
    
    protected $guarded = ['id'];
 
     
    public function room()
    {
    	return $this->belongsTo(Room::class, 'room_id');
    }
}
