<?php

namespace App\Models\HMS;
use App\Models\Hostel;
use App\Models\Room;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'hostel';
    protected $guarded = ['id'];

    public $timestamps = false;

    public function hostel()
    {
    	return $this->belongsTo(Hostel::class, 'hostel_id');
    }

    public function room()
    {
    	return $this->belongsTo(Room::class, 'room_id');
    }
}
