<?php

namespace App\Models\WhatsApp;


use Illuminate\Database\Eloquent\Model;

class WhatsAppTemplate extends Model
{
    protected $connection = 'whats_app';

    protected $table = 'templates';



    protected $fillable = [
        'name', 'message', 'type', 'updated_by', 'updated_by'
    ];
}
