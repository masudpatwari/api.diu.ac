<?php

namespace App\Models\HMS;


use App\Models\Room;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $connection = 'hostel';

    protected $guarded = ['id'];
    
    public $timestamps = false;

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
