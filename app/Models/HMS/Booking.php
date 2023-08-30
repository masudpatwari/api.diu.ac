<?php

namespace App\Models\HMS;
use App\Models\HMS\Hostel;
use App\Models\HMS\Room;

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
    public function  transection()
    {
    	return $this->hasMany(Transaction::class, 'user_id','student_id');
    }

   
}
