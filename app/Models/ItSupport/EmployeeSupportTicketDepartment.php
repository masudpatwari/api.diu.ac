<?php

namespace App\Models\ItSupport;

use Illuminate\Database\Eloquent\Model;

class EmployeeSupportTicketDepartment extends Model
{
    protected $table = "employee_support_ticket_department";
    protected $connection = 'mysql';

    protected $fillable=['support_ticket_department_id','employee_id'];


}
