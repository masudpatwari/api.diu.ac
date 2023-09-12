<?php

namespace App\Http\Controllers\Setting;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;


class EmployeeController extends Controller
{
    use RmsApiTraits;

    public function cmsSyncToErp(Request $request)
    {

        $employee = Employee::with('relAttendanceIds')->find($request->employee_id);
        unset($employee['permissions']);
        unset($employee['profile_photo_file']);
        unset($employee['signature_card_photo_file']);


        $cmsEmployeeSyncToErp = $this->cmsEmployeeSyncToErp($employee);

        if (!$cmsEmployeeSyncToErp) {
            return response()->json(['error' => 'Employee sync to ERP fail.'], 406);
        }

        return response()->json(['message' => $cmsEmployeeSyncToErp['message']], 200);

    }

    public function cmsSyncToAttendance(Request $request)
    {
        $employee = Employee::with('relAttendanceIds', 'relDesignation', 'relDepartment', 'relCampus', 'relShortPosition', 'relOfficeOffDay')
            ->find($request->employee_id);

        $emp = \App\Models\Attendance\Employee::where('att_id', $employee->relAttendanceIds->att_data_id)->first();

        if ($emp) {
            return response()->json(['error' => 'Already Employee sync to Attendance.'], 406);
        }

        $attendance_emp = new \App\Models\Attendance\Employee();
        $attendance_emp->name = $employee->name;
        $attendance_emp->position = $employee->relDesignation->name;
        $attendance_emp->dept = $employee->relDepartment->name;
        $attendance_emp->DOB = date('Y-m-d', $employee->date_of_birth);
        $attendance_emp->DOJ = date('Y-m-d', $employee->date_of_join);
        $attendance_emp->campus = $employee->relCampus->name;
        $attendance_emp->idno = $employee->relAttendanceIds->att_card_id;
        $attendance_emp->preidno = $employee->id;
        $attendance_emp->oadd = $employee->office_address;
        $attendance_emp->ophone = $employee->office_phone_no;
        $attendance_emp->hphone = $employee->home_phone_no;
        $attendance_emp->mno1 = $employee->personal_phone_no;
        $attendance_emp->mno2 = $employee->alternative_phone_no;
        $attendance_emp->smno = $employee->spous_phone_no;
        $attendance_emp->pmno = $employee->parents_phone_no;
        $attendance_emp->omno = $employee->other_phone_no;
        $attendance_emp->email1 = $employee->office_email;
        $attendance_emp->email2 = $employee->private_email;
        $attendance_emp->merit = $employee->merit;
        $attendance_emp->pass = md5('12345678');
        $attendance_emp->activestatus = $employee->activestatus;
        $attendance_emp->att_id = $employee->relAttendanceIds->att_data_id;
        $attendance_emp->emp_short_position = $employee->relShortPosition->name;

        $attendance_emp->holiday = $employee->relOfficeOffDay->day ?? 'monday';
        $attendance_emp->ost = '00:00:00';
        $attendance_emp->oet = '00:00:00';

        $attendance_emp->save();

        return response()->json(['message' => 'Employee sync to Attendance successfully.'], 200);


    }
}
