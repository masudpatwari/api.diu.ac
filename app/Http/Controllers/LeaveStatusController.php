<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveApplication;
use App\LeaveApplicationHistory;
use App\Employee;
use App\SystemSetting;
use App\LeaveApplicationDenyByOther;
use App\Http\Resources\LeaveResource;
use App\Http\Resources\LeaveResourceFlutter;
use App\Http\Resources\LeaveDetailsResource;
use Illuminate\Support\Facades\DB;

class LeaveStatusController extends Controller
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
    * Leave_application list those are waiting for approval on employee.
    * Default this will send application list for current_user's.
    * if user_id passed then this will send application list for that user.
    */
    public function approval(Request $request)
    {
        $leaves = LeaveApplication::where(['status' => 'Pending', 'pending_in_employee_id' => $request->auth->id])->orderBy('id','desc')->limit(100)->get();
        if (!empty($leaves))
        {
            return LeaveResource::collection($leaves);
        }
        return response()->json(NULL, 404);
    }

    /**
    * Leave_application status those are not approved yet. status = pending.
    * Default this will send application list status for current_user's.
    * if user_id passed then this will send application list status for that user.
    */
    public function pending(Request $request)
    {
        $leaves = LeaveApplication::where(['status' => 'Pending', 'employee_id' => $request->auth->id])->get();
        if (!empty($leaves))
        {
            return LeaveResource::collection($leaves);
        }
        return response()->json(NULL, 404);
    }

    /**
    * Leave_application status those are not approved yet. status = pending.
    * Default this will send application list status for current_user's.
    * if user_id passed then this will send application list status for that user.
    */
    public function pendingApp(Request $request)
    {
        $leaves = LeaveApplication::where(['status' => 'Pending', 'employee_id' => $request->auth->id])->get();
        if (!empty($leaves))
        {
            return LeaveResourceFlutter::collection($leaves);
        }
        return response()->json(NULL, 404);
    }


    /**
    * Leave_application list those are approved yet. status = Approved.
    * Default this will send approved application list for current_user's.
    * if user_id passed then this will send approved application list for that user.
    */
    public function approved(Request $request)
    {
        $leaves = LeaveApplication::where(['status' => 'Approved', 'employee_id' => $request->auth->id])->get();
        if (!empty($leaves))
        {
            return LeaveResource::collection($leaves);
        }
        return response()->json(NULL, 404);
    }


    /**
    * Leave_application list those are Denied by Other user. status = deny_by_others.
    * Default this will send application list those Denied by Other for current_user's.
    * if user_id passed then this will send application list those Denied by Other for that user.
    */
    public function deny_by_others(Request $request)
    {
        $leaves = LeaveApplication::where(['status' => 'Deny_By_Others', 'employee_id' => $request->auth->id])->get();
        if (!empty($leaves))
        {
            return LeaveResource::collection($leaves);
        }
        return response()->json(NULL, 404);
    }




    /**
    * Leave_application list those are Denied by Self. status = self_deny.
    * Default this will send application list tthose are Denied by Self for current_user's.
    * if user_id passed then this will send application list those are Denied by Self for that user.
    */
    public function self_deny(Request $request)
    {
        $leaves = LeaveApplication::where(['status' => 'Self_Deny', 'employee_id' => $request->auth->id])->get();
        if (!empty($leaves))
        {
            return LeaveResource::collection($leaves);
        }
        return response()->json(NULL, 404);
    }



    /**
    * Leave_application list those are withdrawed. status = self_deny.
    * Default this will send application list tthose are withdrawed for current_user's.
    * if user_id passed then this will send application list those are withdrawed for that user.
    */
    public function withdraw(Request $request)
    {
        $leaves = LeaveApplication::where(['status' => 'Withdraw', 'employee_id' => $request->auth->id])->get();
        if (!empty($leaves))
        {
            return LeaveResource::collection($leaves);
        }
        return response()->json(NULL, 404);
    }


    /**
    * Leave_application withdraw possible only by applicant when status = pending.
    * That means, when application is not approved.
    */
    public function withdraw_update(Request $request, $id)
    {
        $leave = LeaveApplication::where([
            'id' => $id,
            'status' => 'Pending',
            'employee_id' => $request->auth->id,
        ])->update([
            'status' => 'Withdraw',
        ]);

        if (!empty($leave)) {
            $leave = LeaveApplication::find($id);
            return response()->json($leave, 200);
        }
        return response()->json(['error' => 'Withdraw failed'], 400);
    }

  /**
  * Leave_application withdraw possible only by applicant when status = Approved.
  */
    public function self_deny_update(Request $request, $id)
    {
        $leave = LeaveApplication::find($id);
        $new_leave = $leave->relLeaveApplicationHistory->first();
        if (strtotime(date('Y-m-d')) <= $new_leave->start_date) {
            $leave = LeaveApplication::where([
                'id' => $id,
                'status' => 'Approved',
                'employee_id' => $request->auth->id,
            ])->update([
                'status' => 'Self_Deny',
            ]);

            if (!empty($leave)) {
                $leave = LeaveApplication::find($id);
                return response()->json($leave, 200);
            }
            return response()->json(['error' => 'Deny Failed'], 400);
        }
        return response()->json(['error' => 'Deny date expire'], 400);
    }

    /**
    * This function will Forward/Approve the application.
    */
    public function approved_update(Request $request, $id)
    {
        $system_settings = getSystemSettingValue('employee_ids_who_can_approve_leave_application');
        $approved_array = explode(",", $system_settings);
        $leave_status = (in_array($request->auth->id, $approved_array)) ? 'Approved' : 'Pending';

        $leave = LeaveApplication::where([
            'id' => $id,
            'status' => 'Pending',
            'pending_in_employee_id' => $request->auth->id
        ])->update([
            'status' => $leave_status,
            'pending_in_employee_id' => ($leave_status == 'Pending') ? Employee::supervised_by($request->auth->id) : $request->auth->id,
        ]);

        if (!empty($leave)) {
            $leave = LeaveApplication::find($id);
            return response()->json($leave, 200);
        }
        return response()->json(['error' => 'Approved failed'], 400);
    }

    /**
    * This function will Reject/Deny the application by superordinate Employee.
    */
    public function deny_by_others_update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            LeaveApplication::where([
                'id' => $id,
                'status'=>'Pending',
                'pending_in_employee_id'=>$request->auth->id
            ])->update([
                'status' => 'Deny_By_Others',
            ]);
            LeaveApplicationDenyByOther::create([
                'leaveApplication_id' => $id,
                'created_by' => $request->auth->id,
            ]);
            DB::commit();
            $leave = LeaveApplication::find($id);
            return response()->json($leave, 200);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Deny failed'], 400);
        }
    }
}
