<?php

namespace App\Http\Controllers\ItSupport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItSupport\SupportTicketDepartments;


class SupportTicketDepartmentsController extends Controller
{
    public function index(Request $request)
    {
        return SupportTicketDepartments::pluck('department_name','id');
    }
}
