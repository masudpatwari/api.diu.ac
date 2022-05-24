<?php

namespace App\Models\ItSupport;

use Illuminate\Database\Eloquent\Model;

class SupportTicketDepartments extends Model
{
    protected $table = "support_ticket_departments";
    protected $connection = 'mysql';


    public function supportTicketReplies()
    {
        return $this->hasMany(EmployeeSupportTicketDepartment::class, 'support_ticket_department_id');
    }

    public function supportTicketDepartmentRandomEmployees()
    {
        return $this->hasOne(EmployeeSupportTicketDepartment::class, 'support_ticket_department_id')->inRandomOrder();
    }

}
