<?php

namespace App\Models\ItSupport;

use App\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicketReply extends Model
{
    protected $table = "support_ticket_replies";

    use SoftDeletes;

    protected $fillable = [
        'support_ticket_id',
        'reply_text',
        'created_by',
        'reply_date_time',
    ];

    protected $casts = [
        'reply_date_time' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class,'created_by','id');
    }

    /*public function getReplyDateTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('h:i A,d F ,Y');
    }*/

    public function supportTicketReplyFiles()
    {
        return $this->hasMany(SupportTicketReplyFile::class,'support_ticket_replies_id');
    }

}
