<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Traits\ReportingFunctions;
use App\Traits\LeaveYearlyReview;

class SalaryReportController extends Controller
{
    use ReportingFunctions;
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

    public function index(Request $request)
    {
        $this->validate($request,
            [
                'str_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d',
            ],
            [
                'str_date.required' => 'Starting date is required.',
                'str_date.date_format' => 'Starting date invalid. ( YY-MM-DD ).',
                'end_date.required' => 'Ending date is required.',
                'end_date.date_format' => 'Ending date invalid. ( YY-MM-DD )',
            ]
        );

        $salary_report = $this->salary_report($request, $request->id);
        if (!empty($salary_report)) {
            return response()->json($salary_report, 200);
        }
        return response()->json(NULL, 404);
    }

    public function leave_review_report(Request $request)
    {
        $this->validate($request,
            [
                'str_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d',
            ],
            [
                'str_date.required' => 'Starting date is required.',
                'str_date.date_format' => 'Starting date invalid. ( YY-MM-DD ).',
                'end_date.required' => 'Ending date is required.',
                'end_date.date_format' => 'Ending date invalid. ( YY-MM-DD )',
            ]
        );
        $leave_review_report = $this->leave_yearly_review_date_range($request->id, $request->str_date, $request->end_date);
        if (!empty($leave_review_report)) {
            return response()->json($leave_review_report, 200);
        }
        return response()->json(NULL, 404);
    }

    public function leave_review_reports(Request $request)
    {
        $idsString = getSystemSettingValue("remove_employee_ids_from_salaray_report");
        $idArray = explode(',', $idsString);

        $employees = Employee::select('id')->where('activestatus', '1')->where('salary_report_sort_id','>',0)->whereNotIn('id',$idArray)->orderBy('salary_report_sort_id', 'asc')->pluck('id');


        $this->validate($request,
            [
                'str_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d',
            ],
            [
                'str_date.required' => 'Starting date is required.',
                'str_date.date_format' => 'Starting date invalid. ( YY-MM-DD ).',
                'end_date.required' => 'Ending date is required.',
                'end_date.date_format' => 'Ending date invalid. ( YY-MM-DD )',
            ]
        );

        foreach ($employees as $employee) {
            $leave_review_report[] = $this->leave_yearly_reviews_date_range($employee, $request->str_date, $request->end_date);
        }
        if (!empty($leave_review_report)) {
            return response()->json($leave_review_report, 200);
        }
        return response()->json(NULL, 404);
    }

    public function getEmployeeIDsForSalaryReport()
    {
        $idsString = getSystemSettingValue("remove_employee_ids_from_salaray_report");
        $idArray = explode(',', $idsString);

        return response()->json(
            Employee::select('id')->where('activestatus', '1')->where('salary_report_sort_id','>',0)->whereNotIn('id',$idArray)->take(10)->orderBy('salary_report_sort_id', 'asc')->pluck('id'), 200);
//        return response()->json(
//            Employee::select('id')->where('activestatus', '1')->where('salary_report_sort_id','>',0)->whereNotIn('id',$idArray)->orderBy('salary_report_sort_id', 'asc')->pluck('id')
//          , 200);
    }

    public function getSalaryReport()
    {
        $idsString = getSystemSettingValue("remove_employee_ids_from_salaray_report");
        $idArray = explode(',', $idsString);

        $employees = Employee::select('id')->where('activestatus', '1')->where('salary_report_sort_id','>',0)->whereNotIn('id',$idArray)->take(5)->orderBy('salary_report_sort_id', 'asc')->pluck('id');



//        return response()->json(
//            Employee::select('id')->where('activestatus', '1')->where('salary_report_sort_id','>',0)->whereNotIn('id',$idArray)->orderBy('salary_report_sort_id', 'asc')->pluck('id')
//          , 200);
    }

}
