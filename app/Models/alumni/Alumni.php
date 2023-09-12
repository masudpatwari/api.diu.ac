<?php

namespace App\Models\alumni;

use App\Models\alumni\AlumniJobDetail;
use App\Traits\AuthToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\Alumni as Authenticatable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Alumni extends Model
{
//    use HasApiTokens, HasFactory, Notifiable;
    use AuthToken;

    protected $connection = "almni";

    protected $table = 'alumnies';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'phone' => 'array',
        'email' => 'array',
        'email_verified_at' => 'datetime',
    ];

    public function alumni_job_details()
    {
        return $this->hasMany(AlumniJobDetail::class, 'alumni_id');
    }
}
