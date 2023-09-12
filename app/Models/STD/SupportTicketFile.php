<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicketFile extends Model
{
    protected $table = "support_ticket_files";
    protected $connection = 'std';
    use SoftDeletes;

    protected $fillable = [
        'support_ticket_id',
        'file_url',
    ];

}
