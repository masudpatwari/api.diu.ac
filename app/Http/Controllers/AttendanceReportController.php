<?php

namespace App\Http\Controllers;

use App\Jobs\Job;
use App\Jobs\Pbx\DailySmsJob;
use App\Jobs\Pbx\WeeklySmsJob;
use App\Jobs\Pbx\MonthlySmsJob;
use Illuminate\Http\Request;
use App\Traits\ReportingFunctions;
use App\Models\Attendance\AttendenceMessage;
use App\Employee;
use App\EmployeeRole;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

class AttendanceReportController extends Controller
{
    use ReportingFunctions;

    const DAILY = 'daily_sms';
    const WEEKLY = 'weekly_sms';
    const MONTHLY = 'monthly_sms';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function personal(Request $request)
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
                'no_of_days.required' => 'No of days is required.',
            ]
        );
        return response()->json($this->employee_attendance_report($request, $request->auth->id));
    }

    public function employee(Request $request)
    {

        $this->validate($request,
            [
                'employee_id' => 'required|numeric|exists:employees,id',
                'str_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d',
            ],
            [
                'employee_id.required' => 'Employee name is required.',
                'employee_id.numeric' => 'Invalid employee id.',
                'employee_id.exists' => 'Employee does not exists.',
                'str_date.required' => 'Starting date is required.',
                'str_date.date_format' => 'Starting date invalid. ( YY-MM-DD ).',
                'end_date.required' => 'Ending date is required.',
                'end_date.date_format' => 'Ending date invalid. ( YY-MM-DD )',
                'no_of_days.required' => 'No of days is required.',
            ]
        );


        if (
            EmployeeRole::isAdmin($request->auth->id) ||
            Employee::isSubordinate($request->auth->id, $request->employee_id)
        ) {
            try {
                return response()->json($this->employee_attendance_report($request, $request->employee_id));
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

        }
        return response()->json(['error' => "No Permission !"], 400);

    }

    public function salaryReportSortSettings(Request $request)
    {
        $this->validate($request,
            [
                'emp.*' => 'bail|required|integer|min:0',
            ]

        );

        foreach ($request->emp as $id => $val) {
            $emp = Employee::where('id', $id)->first();
            $emp->salary_report_sort_id = $val;
            $emp->save();
        }

        return response()->json(['success' => 'success '], 200);
    }

    public function attendance_sms_config(Request $request)
    {
        try {
            $days = $request->days;

            AttendenceMessage::truncate();

            if ($days) {
                foreach ($days as $day) {
                    AttendenceMessage::updateOrCreate([
                        'schedule' => $day,
                    ]);
                }
            }


            // Job for each schedule
            $this->jobSync();


            return response()->json(['success' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }

    public function jobSync()
    {
        $schedules = AttendenceMessage::pluck('schedule')->toArray();


        $jobs = DB::table('jobs')->whereIn('queue', [self::DAILY, self::MONTHLY, self::WEEKLY])->pluck('queue')->toArray();


        if (!in_array('daily', $schedules)) {
            DB::table('jobs')->where('queue', self::DAILY)->delete();
        } else {
            if (!in_array(self::DAILY, $jobs)) {
                $job = (new DailySmsJob())->onQueue(self::DAILY);
                $this->dispatch($job);
            }
        }


        if (!in_array('weekly', $schedules)) {
            DB::table('jobs')->where('queue', self::WEEKLY)->delete();
        } else {
            if (!in_array(self::WEEKLY, $jobs)) {
                $job = (new WeeklySmsJob())->onQueue(self::WEEKLY);
                $this->dispatch($job);
            }
        }


        if (!in_array('monthly', $schedules)) {
            DB::table('jobs')->where('queue', self::MONTHLY)->delete();
        } else {
            if (!in_array(self::MONTHLY, $jobs)) {
                $job = (new WeeklySmsJob())->onQueue(self::MONTHLY);
                $this->dispatch($job);
            }
        }
    }
}
