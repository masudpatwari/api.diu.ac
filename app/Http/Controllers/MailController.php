<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\STD\Student;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'department_id' => 'required',
                'batch_id' => 'required',
                'subject' => 'required',
                'message' => 'required',
                'attechment_file' => 'max:20480',
            ]
        );
        $department_id = $request->input('department_id');
        $batch_id = $request->input('batch_id');

        $student_emails = Student::where(['DEPARTMENT_ID' => $department_id, 'BATCH_ID' => $batch_id])->whereNotNull('EMAIL')->pluck('EMAIL');
        $employee = Employee::find($request->auth->id);
        Mail::to($employee->office_email)->bcc($student_emails)->send(new TestMail($employee));
    }

    public function show($id)
    {
        //
    }
}

