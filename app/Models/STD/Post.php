<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	protected $table = "wp_posts";
    protected $connection = 'std';

    protected $fillable = [

    ];

}
