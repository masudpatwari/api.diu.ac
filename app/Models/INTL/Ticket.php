<?php

namespace App\Models\INTL;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $connection = 'intl';

    protected $fillable = [
        'ticket_id', 'name', 'email', 'body', 'status', 'type', 'method', 'agent_id'
    ];
}
