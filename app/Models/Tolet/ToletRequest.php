<?php

namespace App\Models\Tolet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToletRequest extends Model
{
    protected $connection = 'tolet';
    
    public $timestamps = false;

    // const PENDING = 0;
    // const APPROVED = 1;
}
