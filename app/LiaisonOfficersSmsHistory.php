<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiaisonOfficersSmsHistory extends Model
{
	protected $fillable = [
		'mobile_no', 'message'
	];
}
