<?php

namespace App\Models\Tolet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodDonate extends Model
{
    protected $connection = 'tolet';
    protected $fillable = ['students_id','last_donate'];
    
     public $timestamps = false;
}
