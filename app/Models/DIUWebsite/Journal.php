<?php

namespace App\Models\DIUWebsite;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = "journals";

    protected $fillable = [
        'title',
        'author',
        'abstract'
        
    ];

   

}
