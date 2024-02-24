<?php

namespace App\Models\IndLinkage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{
//    use HasApiTokens, HasFactory, Notifiable;
//    use HasFactory;
    protected $connection = "indlkg";

    protected $guarded = ['id'];

    protected $casts = [
        'phone' => 'array',
    ];
    protected $hidden = ['id'];

    public function company_employee()
    {
        return $this->hasMany(Company_Employee::class, 'company_id');
    }
}
