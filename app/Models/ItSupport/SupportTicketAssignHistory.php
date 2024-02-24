<?php

namespace App\Models\ItSupport;

use App\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SupportTicketAssignHistory extends Model
{
    protected $table = "support_ticket_assign_histories";
    protected $connection = 'mysql';

    protected $fillable = [
        'support_ticket_id',
        'assign_by',
        'assign_to',
        'assign_date_time',
        'created_at',
        'updated_at',
    ];

    public function assignBy()
    {
        return $this->belongsTo(Employee::class,'assign_by','id');
    }

    public function assignTo()
    {
        return $this->belongsTo(Employee::class,'assign_to','id');
    }

    public function getAssignDateTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:m:s A , d M,Y') : 'N/A';
    }


}
