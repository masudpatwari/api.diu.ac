<?php

namespace App\Models\INTL;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
	// protected $table = "foreign_students";
    protected $connection = 'intl';
/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile_no', 'password', 'role', 'profile_photo', 'email_verified_at', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


}
