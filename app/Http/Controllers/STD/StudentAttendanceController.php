<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\STD\AttendanceData;
use App\Models\STD\AttendanceReport;
use App\Models\STD\Department;
use App\Http\Resources\StudentsAttendanceReportResource;
use App\Http\Resources\StudentsAttendanceResource;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;
use App\Traits\RmsApiTraits;

class StudentAttendanceController extends Controller
{
    use RmsApiTraits;

    public function attendance_update_as_final(){
        $days_ago = date("Y-m-d", strtotime("-3 day"));

        AttendanceData::where('date','<',$days_ago)->where('status','draft')->update([
            'status' => 'final'
        ]);

    }

    public function attendance_departments(Request $request)
    {
        

        $input = [
            'email' =>  $request->auth->office_email
        ];
        $url = env('RMS_API_URL').'/attendance_departments';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->post();


        return  response()->json($response->content, $response->status);
    }


    public function attendance_students($department_id, $batch_id)
    {
        $input = [
            'department_id' =>  $department_id,
            'batch_id' =>  $batch_id

        ];
        $url = env('RMS_API_URL').'/attendance_students';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);
    }

    public function attendance_batch_students($batch_id)
    {
        $input = [
            'batch_id' =>  $batch_id
        ];
        $url = env('RMS_API_URL').'/attendance_batch_students';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);
    }

    public function get_attendance_departments()
    {
        $this->attendance_update_as_final();

        $departments = AttendanceData::select('department_id', 'department_name')
        ->groupBy('department_id', 'department_name')
        ->orderBy('department_name')
        ->get();
        
        if (!empty($departments)) {
            return  response()->json($departments, 200);
        }
        return  response()->json(NULL, 400);
    }

    public function get_attendance_batch( int $department_id )
    {
        $batch = AttendanceData::select('batch_id', 'batch_name')
        ->where('department_id', $department_id)
        ->groupBy('batch_id', 'batch_name')
        ->orderBy('batch_name')
        ->get();

        if (!empty($batch)) {
            return  response()->json($batch, 200);
        }
        return  response()->json(NULL, 400);
    }

    public function get_attendance_course(Request $request, int $batch_id )
    {
        $course = AttendanceData::select('course_id', 'course_name', 'course_code')
        ->where('batch_id', $batch_id);

        if ($request->has('semester')) {
            $course->where('semester', $request->semester );
        }

        $courseList = $course->groupBy('course_id', 'course_name', 'course_code')
        ->orderBy('course_name')
        ->get();


        if ( $courseList->count() > 0) {
            return  response()->json($courseList, 200);
        }
        return  response()->json(NULL, 400);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function attendance_reports(Request $request)
    {
        $this->validate($request,
            [
                'department_id' => 'required',
                'batch_id' => 'required',
                'semester' => 'required',
                'course_id' => 'required',
            ]
        );
        $department_id = $request->input('department_id');
        $batch_id = $request->input('batch_id');
        $semester = $request->input('semester');
        $course_id = $request->input('course_id');
        $date = $request->input('date');

        /*$department_id = 2;
        $batch_id = 257;
        $course_id = 397;*/
        $date = $request->input('date');

        $input = [
            'department_id' =>  $department_id,
            'batch_id' =>  $batch_id

        ];
        $url = env('RMS_API_URL').'/attendance_students';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->post();

        $attendance_dates = AttendanceData::with('relAttendanceReport')
            ->where([
                'department_id' => $department_id,
                'batch_id' => $batch_id,
                'course_id' => $course_id,
                'semester' => $semester,
            ])
            ->orderBy('date','desc')
            ->get();

        $stdData = '';
        if (!empty($response->content)) {
            $stdData = $response->content['data'];
        }
        else{
            return response()->json(['error'=>'students not found'],400);
        }

        if (empty($attendance_dates) || count($attendance_dates) == 0) {
            return response()->json(['error' => 'Attendance not taken'], 404);
        }

        $accountsSummary = $this->rmsBatchWiseAccountsReportNonCovid( $batch_id );

        if ( $accountsSummary == false ) {
            return response()->json(['error'=>'Account Data Not Found!'], 400);
        }
         
        $accountsSummaryCollection = collect( $accountsSummary );
         
        $dates = [];
        $attendate_p_a = [];

        foreach ($attendance_dates as $key => $attendance) {
            $fulldatetime = str_replace(["-"," ",":"], ["","",""], $attendance->full_date_time);
            $full_date_time = $attendance->full_date_time;
            $check_attendance = $attendance->relAttendanceReport->pluck('student_id')->toArray();
            
            foreach ($stdData as $std) {
                $std_id = $std['id'];

                if ( in_array($std_id, $check_attendance) ) {
                    if ($attendance->no_of_attendance==1) {
                        $attendate_p_a [$std_id][] = 1;
                    }else{
                            $attendate_p_a [$std_id][] = 2;
                            $attendate_p_a [$std_id][] = 2;
                    }
                }else{
                    if ($attendance->no_of_attendance==1) {
                        $attendate_p_a [$std_id][] = 0;
                    }else{
                            $attendate_p_a [$std_id][] = 0;
                            $attendate_p_a [$std_id][] = 0;
                    }
                }


                $dates['attendance'][$std_id]['attendance_dates'][$full_date_time] = [
                    'date_time' => $attendance->full_date_time,
                    'status' => (in_array($std_id, $check_attendance)) ? "P" : "A",
                ];

                $present_abs_count = array_count_values($attendate_p_a [$std_id]);
                $total_present = ($present_abs_count['2']??0 ) + ($present_abs_count['1']?? 0);
                $total_absent = $present_abs_count[0]??0;

                
                $dates['attendance'][$std_id]['present_count'] = [
                    'present'=>$total_present,
                    'absent'=>$total_absent,                    
                ];

                $stuAcc = $accountsSummaryCollection->where('id', $std_id)->first();

                $dates['attendance'][$std_id]['student'] = [
                    'name' => $std['name'],
                    'roll_no' => $std['roll_no'],
                    'phone_number' => $stuAcc->phone_no??'NF',
                    'total_current_due' => ceil( $stuAcc->summary->total_current_due ?? 0) . '.00',
                ];

            }

        }
        
        // return (  );

        return response()->json($dates, 200);

    }

    /**
     * @param Request $request
     * @param $department_id
     * @param $batch_id
     * @param $semester
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check_attendance(Request $request, $department_id, $batch_id, $semester, $course_id)
    {
        $mutable = Carbon::now();
        $today = $mutable->format('Y-m-d');
        $subdays = $mutable->subDays(300)->format('Y-m-d');
        $regexHHMM_AMPM = 'regex:/^(0[0-9]|1[0-2]|[0-9]){1}:[0-5][0-9] ( |\+)?(AM|PM){1}( |\+)?$/i';

        $this->validate($request,
            [
                'date' => 'required|date_format:Y-m-d|date|after_or_equal:'.$subdays.'|before_or_equal:'.$today.'',
                'time' => [$regexHHMM_AMPM],
            ]
        );
        $date = $request->input('date');
        $time = $request->input('time');
        $employee_id = $request->auth->id;

        $attendance_data = AttendanceData::with('relAttendanceReport')->where([
            'employee_id' => $employee_id,
            'date' => $date,
            'department_id' => $department_id,
            'batch_id' => $batch_id,
            'course_id' => $course_id
        ])->first();

        if (!empty($attendance_data)) {
            $check_attendance = $attendance_data->relAttendanceReport->pluck('student_id')->toArray();
            return response()->json(['info' => $attendance_data, 'attendance' => $check_attendance], 200);
        }
        return response()->json(['error' => 'Attendance data not found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $department_id
     * @param $batch_id
     * @param $semester
     * @param $course_id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $department_id, $batch_id, $semester, $course_id)
    {
        $mutable = Carbon::now();
        $today = $mutable->format('Y-m-d');
        $subdays = $mutable->subDays(300)->format('Y-m-d');
    	$regexHHMM_AMPM = 'regex:/^(0[0-9]|1[0-2]|[0-9]){1}:[0-5][0-9] ( |\+)?(AM|PM){1}( |\+)?$/i';


    	$this->validate($request,
            [
                'date' => 'required|date_format:Y-m-d|date|after_or_equal:'.$subdays.'|before_or_equal:'.$today.'',
                'time' => ['required', $regexHHMM_AMPM],
                'no_of_attendance' => ['required', 'integer'],
                'comments.*' => ['sometimes', 'string'],
            ]
        );

        if($request->filled('comments'))
        {
            $comments = $request->input('comments');
            $comments = array_filter($comments);
        }
        else
        {
            $comments = [];
        }


        $date = $request->input('date');
        $time = $request->input('time');
        $student_ids = $request->input('ids');
        $no_of_attendance = $request->input('no_of_attendance');
        $save_as = $request->input('save_as');
        $employee_id = $request->auth->id;



        $input = [
            'email' =>  $request->auth->office_email
        ];

        $url = env('RMS_API_URL').'/attendance_departments';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->post();
        $collection = collect($response->content['data']);
        $filtered = $collection->where('department_id', $department_id)->where('batch_id', $batch_id)->where('semester', $semester)->where('course_id', $course_id)->first();

        if (empty($filtered)) {
            return response()->json(['error' => 'There is no assigned department to you.'], 400);
        }
        $resource = new AttendanceData();
        $check_draft_sql = $resource;
        $check_exists_sql = $resource;
        $check_attendance_sql = $resource;

        $check_attendance = $check_attendance_sql->where([
            'employee_id' => $employee_id,
            'date' => $date,
            'department_id' => $department_id,
            'batch_id' => $batch_id,
            'semester' => $semester,
            'course_id' => $course_id,
        ])->first();

        try {
            DB::connection('std')->beginTransaction();

            if (empty($check_attendance)) {
                $check_exists_attendance = $check_draft_sql->where(['employee_id' => $employee_id])->pluck('id', 'status')->toArray();
                if (!empty($check_exists_attendance)) {
                    if (array_key_exists('draft', $check_exists_attendance)) {

                        $exists_attendance_id = $check_exists_attendance['draft'];

                        $check_exists_attendance = $check_exists_sql->where(['id' => $exists_attendance_id, 'employee_id' => $employee_id, 'status' => 'draft'])->first();
                        return response()->json(['error' => 'Please final submit your previous draft. '.$check_exists_attendance->department_name.' Batch '.$check_exists_attendance->batch_name.' Course Name '.$check_exists_attendance->course_name.' Code '.$check_exists_attendance->course_code.' Semester '.$check_exists_attendance->semester.' Date '.$check_exists_attendance->date.''], 400);
                    }
                }
                $attendance_array = [
                    'employee_id' => $employee_id,
                    'department_id' => $department_id,
                    'date' => $date,
                    'time' => $time,
                    'no_of_attendance' => $no_of_attendance,
                    'department_name' => $filtered['department_name'],
                    'batch_id' => $batch_id,
                    'batch_name' => $filtered['batch_name'],
                    'semester' => $semester,
                    'course_id' => $course_id,
                    'course_name' => $filtered['name'],
                    'course_code' => $filtered['code'],
                    'status' => $save_as,
                ];
                $attendance_data_array = $resource->create($attendance_array);
                $attendance_data_id = $attendance_data_array->id;
            }
            else
            {
                $attendance_data_id = $check_attendance->id;

                if ($check_attendance->status == 'final') {
                    return response()->json(['error' => 'You have already submitted attendance data'], 400);
                }

                $check_exists_attendance = $check_exists_sql->where('id', '!=', $attendance_data_id)->where(['employee_id' => $employee_id, 'status' => 'draft'])->first();
                if (!empty($check_exists_attendance)) {
                    return response()->json(['error' => 'Please final submit your previous draft. '.$check_exists_attendance->department_name.' Batch '.$check_exists_attendance->batch_name.' Course Name '.$check_exists_attendance->course_name.' Code '.$check_exists_attendance->course_code.' Semester '.$check_exists_attendance->semester.' Date '.$check_exists_attendance->date.''], 400);
                }

                $resource->where(['id' => $attendance_data_id])->update([
                    'status' => $save_as,
                    'time' => $time,
                ]);
                AttendanceReport::where(['attendance_data_id' => $attendance_data_id])->delete();
            }


            if (!empty($student_ids)) {
                foreach ($student_ids as $key => $id) {
                    $array[] = [
                        'attendance_data_id' => $attendance_data_id,
                        'student_id' => $id,
                        'comments' => count($comments)>0 ? $comments[$id] : '',
                        'created_at' => $today,
                        'updated_at' => $today,
                    ];
                }


                AttendanceReport::insert($array);
            }

            DB::connection('std')->commit();
            return response()->json(['success' => 'Attendance upload Successfull.'] , 201);
        } catch (\PDOException $e) {
            DB::connection('std')->rollBack();
            return response()->json(['error' => 'Attendance upload Failed.'.$e], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    public function attendance_sms()
    {
        $department = Department::get();
    }
}
