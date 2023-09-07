<?php

namespace App\Models\STD;

use App\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicketReplyFile extends Model
{
    protected $table = "support_ticket_reply_files";
    protected $connection = 'std';

    use SoftDeletes;

    protected $fillable = [
        'support_ticket_replies_id',
        'file_url',
    ];

}
