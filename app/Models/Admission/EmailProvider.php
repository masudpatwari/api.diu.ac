<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Model;

class EmailProvider extends Model
{
    protected $table = "email_providers";
    protected $connection = 'intl';

    protected $fillable = [
        'driver',
        'host',
        'port',
        'encryption',
        'sender_name',
        'sender_email',
        'password',
        'status',
        'username',
    ];

    public function scopeactive($query)
    {
        $query->whereStatus('1');
    }

}
