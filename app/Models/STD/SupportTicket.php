<?php

namespace App\Models\STD;

use App\Employee;
use App\Models\ItSupport\SupportTicketDepartments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicket extends Model
{
    protected $table = "support_tickets";
    protected $connection = 'std';

    use SoftDeletes;

    protected $fillable = [
        'purpose',
        'subject',
        'status',
        'type',
        'priority',
        'created_by',
        'updated_by',
        'assaign_to',
        'assign_date_time',
        'deny_by',
        'deny_reason',
        'canceled_by',
        'cancel_date_time',
        'completed_by',
        'completed_date_time',
        'permission_details',
        'permission_seeker_id',
        'permission_status',
        'permission_seeker_date_time',
        'permission_seeker_feedback_date_time',
        'deny_date_time',
        'support_ticket_department_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'assign_date_time'                      => 'datetime',
        'cancel_date_time'                      => 'datetime',
        'completed_date_time'                   => 'datetime',
        'permission_seeker_date_time'           => 'datetime',
        'permission_seeker_feedback_date_time'  => 'datetime',
    ];

    public function supportTicketFiles()
    {
        return $this->hasMany(SupportTicketFile::class,'support_ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(Student::class,'created_by','ID');
    }

    public function assign()
    {
        return $this->belongsTo('App\Employee', 'assaign_to', 'id')->select('id','name');
    }

    public function deny()
    {
        return $this->belongsTo('App\Employee','deny_by','id');
    }

    public function cancel()
    {
        return $this->belongsTo('App\Employee','canceled_by','id');
    }

    public function completed()
    {
        return $this->belongsTo('App\Employee','completed_by','id');
    }

    public function permissionSeeker()
    {
        return $this->belongsTo('App\Employee','permission_seeker_id','id');
    }

    public function supportTicketReplies()
    {
        return $this->hasMany(SupportTicketReply::class,'support_ticket_id');
    }

    public function ticketAssignBy()
    {
        return $this->belongsTo('App\Employee','assign_by','id')->select('id','name');
    }

    public function permissionSeekBy()
    {
        return $this->belongsTo('App\Employee','permission_seek_by','id')->select('id','name');
    }

    public function support_ticket_department()
    {
        return $this->belongsTo(SupportTicketDepartments::class,'support_ticket_department_id','id');
    }

}
