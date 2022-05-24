<?php

namespace App\Models\IndLinkage;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Company_Employee extends Model
{
//    use HasFactory;
    protected $connection = "indlkg";

    protected $table = 'comapany_employee';
    protected $guarded = ['id'];
    public $timestamps = true;
}
