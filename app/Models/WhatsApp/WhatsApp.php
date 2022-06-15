<?php

namespace App\Models\WhatsApp;


use Illuminate\Database\Eloquent\Model;

class WhatsApp extends Model
{
    protected $connection = 'whats_app';

    protected $table = 'messages';

    protected $fillable = [
        'employee_name'
    ];
}
