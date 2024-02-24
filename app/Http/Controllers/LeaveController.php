<?php

namespace App\Http\Controllers;

use App\Mail\EmployeeConfirmMail;
use App\Mail\EmployeeLeaveAlertMail;
use Illuminate\Http\Request;
use App\LeaveApplication;
use App\LeaveApplicationHistory;
use App\Employee;
use App\LeaveApplicationComment;
use App\LeaveApplicationDenyByOther;
use App\Http\Resources\LeaveDetailsResource;
use App\Http\Resources\LeaveEditResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\EmployeeShortDetailsResource;
use App\Rules\CheckSameYear;
use App\EmployeeRole;
use App\Traits\LeaveYearlyReview;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    use LeaveYearlyReview;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(Request $request, $id)
    {
        $leaves = LeaveApplication::where(['id' => $id])->first();
        if (!empty($leaves))
        {
            return new LeaveDetailsResource($leaves);
        }
        return response()->json(NULL, 404);
    }

    public function edit(Request $request, $id)
    {
        $leaves = LeaveApplication::where(['id' => $id, 'pending_in_employee_id' => $request->auth->id])->first();
        if (!empty($leaves))
        {
            return new LeaveEditResource($leaves);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'kinds_of_leave' => 'required|in:Earned,Without Pay,Study,Maternity,Others',
                'causes_of_leave' => 'required|max:100',
                'str_date' => 'required|date_format:Y-m-d|before:' . date('Y-m-d', strtotime('+1 day', strtotime($request->str_date))),
                'end_date' => [new CheckSameYear($request->input('str_date'))],
                'no_of_days' => 'required|numeric|min:1',
                'have_permission' => 'required',
                'accept_it' => 'accepted',
                'alt_employee' => 'required|exists:employees,id',
            ],
            [
                'kinds_of_leave.required' => 'Kinds of leave is required.',
                'kinds_of_leave.in_array' => 'Kinds of leave is invalid.',
                'alt_employee.required' => 'Alternate Employee is required.',
                'alt_employee.exits' => 'Must select an existing employee.',
                'causes_of_leave.required' => 'Causes of leave is required.',
                'causes_of_leave.max' => 'There is a limit of 100 characters.',
                'str_date.required' => 'Starting date is required.',
                'str_date.date_format' => 'Starting date format must be "YYYY-MM-DD".',
                'str_date.before' => 'Starting date less than end date.',
                'end_date.required' => 'Ending date is required.',
                'end_date.date_format' => 'Ending date format must be "YYYY-MM-DD".',
                'end_date.after' => 'Ending date greater than start date',
                'no_of_days.required' => 'No of days is required.',
                'no_of_days.numeric' => 'Only number are allow.',
                'no_of_days.min' => 'At least 1 day is necessary.',
                'have_permission.required' => 'Need permission is required.',
                'accept_it.accepted' => 'Please accept it.',
            ]
        );

        try {
            // DB::beginTransaction();
            $leave_array = [
                'employee_id' => $request->auth->id,
                'status' => 'Pending',
                'pending_in_employee_id' => Employee::supervised_by($request->auth->id),
                'alt_employee' => $request->input('alt_employee'),
                'cause' => $request->input('causes_of_leave'),
                'need_permission' => $request->input('have_permission'),
                'accept_salary_difference' => 1
            ];
            $leave = LeaveApplication::create($leave_array);

            $leave_history_array = [
                'leaveApplication_id' => $leave->id ?? $request->auth->id,
                'kindofleave' => $request->input('kinds_of_leave'),
                'start_date' => date_to_datestamp($request->input('str_date')),
                'end_date' => date_to_datestamp($request->input('end_date')),
                'number_of_days' => $request->input('no_of_days'),
                'created_by' => $request->auth->id,
            ];
            LeaveApplicationHistory::create($leave_history_array);

            $employee = Employee::find($request->auth->id);
            $alt_employee = Employee::find($leave->alt_employee);

            try {
                $mail = Mail::to($alt_employee->office_email)
                    ->cc($alt_employee->private_email)
                    ->send(new EmployeeConfirmMail($employee, $leave));

            }catch (\Exception $e) {
                dd($e->getMessage());
            }
            // DB::commit();
            return response()->json(NULL, 201);
        } catch (\PDOException $e) {
            // DB::rollBack();
            return response()->json(['error' => 'Insert Failed.'], 400);
        }
    }

    public function update(Request $request, $id)
    {

        $this->validate($request,
            [
                'kinds_of_leave' => 'required|in:Earned,Without Pay,Study,Maternity,Others',
                'str_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d',
                'no_of_days' => 'required|numeric|min:1',
            ],
            [
                'kinds_of_leave.required' => 'Kinds of leave is required.',
                'kinds_of_leave.in_array' => 'Kinds of leave is invalid.',
                'str_date.required' => 'Starting date is required.',
                'str_date.date_format' => 'Starting date format must be "YYYY-MM-DD".',
                'end_date.required' => 'Ending date is required.',
                'end_date.date_format' => 'Ending date format must be "YYYY-MM-DD".',
                'no_of_days.required' => 'No of days is required.',
                'no_of_days.numeric' => 'Only number are allow.',
                'no_of_days.min' => 'At least 1 day is necessary.',
            ]
        );


        $leave_history_array = [
            'leaveApplication_id' => $id,
            'kindofleave' => $request->input('kinds_of_leave'),
            'start_date' => date_to_datestamp($request->input('str_date')),
            'end_date' => date_to_datestamp($request->input('end_date')),
            'number_of_days' => $request->input('no_of_days'),
            'created_by' => $request->auth->id,
        ];
        try {
            DB::beginTransaction();
            LeaveApplicationHistory::where(['leaveApplication_id' => $id])->delete();
            LeaveApplicationHistory::create($leave_history_array);
            DB::commit();
            return response()->json(NULL, 200);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Update Failed.'], 400);
        }
    }

    public function comment(Request $request, $id)
    {
        /***
        * check is application pending in me.
        */
        $check_exists = LeaveApplication::where(['id' => $id, 'status' => 'Pending', 'pending_in_employee_id' => $request->auth->id])->exists();
        if ($check_exists) {
            $this->validate($request,
                [
                    'comment' => 'required',
                ],
                [
                    'comment.required' => 'Comment is required.',
                ]
            );
            $comment_array = [
                'leaveApplication_id' => $id,
                'comment' => $request->input('comment'),
                'created_by' => $request->auth->id,
            ];

            $comment = LeaveApplicationComment::create($comment_array);
            if (!empty($comment->id)) {
                return response()->json($comment, 201);
            }
            return response()->json(['error' => 'Failed.'], 400);
        }
        return response()->json(['error' => 'You have no permission.'], 400);
    }

    public function yearly_review(Request $request, $employee_id = null)
    {
        if (empty($employee_id)) {
            $employee_id = $request->auth->id;
        }
        return $this->leave_yearly_review( $employee_id );
    }

    public function superordinate(Request $request)
    {
        return $employee = Employee::superordinate($request->auth->id);
        if (!empty($employee))
        {
            return response()->json($employee, 200);
        }
        return response()->json(NULL, 404);
    }

    public function subordinate(Request $request)
    {

        if( EmployeeRole::isAdmin($request->auth->id) )
        {
            $employees = Employee::orderBy('id', 'asc')->where('activestatus', '1')->get();
            if (!empty($employees))
            {
                $data['data'][0] =  EmployeeResource::collection($employees);
                return $data;
            }
        }



        $employee = Employee::subordinate($request->auth->id);
        if (!empty($employee))
        {
            return response()->json($employee, 200);
        }
        return response()->json(NULL, 404);
    }
    
    public function subordinateCount (Request $request)
    {
    	if( EmployeeRole::isAdmin($request->auth->id) )
        {
            $employees = Employee::orderBy('id', 'asc')->where('activestatus', '1')->get();
            if (!empty($employees))
            {
                $data['data'][0] =  EmployeeResource::collection($employees);
                return $data;
            }
        }
    }

    public function coordinate(Request $request)
    {
        return$employee = Employee::coordinate($request->auth->id);
        if (!empty($employee))
        {
            return response()->json($employee, 200);
        }
        return response()->json(NULL, 404);
    }
    
    public function supervisor()
    {
    return ['test','only'];
 	$data['employee'] = [];
	$data['supervisors'] = Employee::with('relDesignation:name,id', 'relDepartment:name,id')->whereNotNull('supervised_by')->where('activestatus', '1')->orderBy('supervised_by', 'asc')->get();
	   
	$data['supervised'] = $data['supervisors']->groupBy('supervised_by'); 
	   
	foreach($data['supervised'] as $key => $supervisor)
	{
		$employee = $data['supervisors']->find($key);
		
		if(!$employee)
		{
			$employee = Employee::with('relDesignation:name,id', 'relDepartment:name,id')->find($key);
		}
		
		$data['employee'][$key] = $employee;
	}
    	 
    	return $data;   
    }


    public function confirm_email($token)
    {
        $explode_by = '.0.0.0.0.';

        $info = explode($explode_by, decrypt($token));

        $application_id = $info[0];
        $timeout = $info[1];
        $user_id = $info[2];

        $leave = LeaveApplication::find($application_id);

        if(!$leave) {
            return redirect()->route('login')->with('error', 'Invalid link.');
        }

        if($leave->alt_employee == $user_id && date('Y-m-d H:i:s', $timeout) > date('Y-m-d H:i:s'))
        {
            $leave->update(['alt_employee_approved' => 1]);
        }

        $employee_id = $leave->employee_id;


        $employee = Employee::find($employee_id);
        $alt_user = Employee::find($user_id);

        if(!$employee) {
            return redirect()->route('login')->with('error', 'Invalid link.');
        }

        $department = $employee->department_id;


        $emails = Employee::where('department_id', $department)->pluck('office_email');

        $leave_history = LeaveApplicationHistory::where('leaveApplication_id', $leave->id)->first();

        Mail::to($emails)->send(new EmployeeLeaveAlertMail($employee, $leave_history, $alt_user));

        return response()->json('Confirmed Successfully', 404);
    }

}
