<?php

namespace App\Models\HMS;
use App\Models\Seat;
use App\Models\Room;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $connection = 'hostel';

    protected $guarded = ['id'];
    
    public $timestamps = false;


    public function oldSeat()
    {
        return $this->belongsTo(Seat::class, 'from');
    }

    public function newSeat()
    {
        return $this->belongsTo(Seat::class, 'to');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'to');
    }
}
