<?php

namespace App\Http\Controllers\Job;

use App\classes\smsWithPBX;
use App\Jobs\Pbx\SendSmsJob;
use App\Models\PBX\PbxCampaign;
use App\Models\PBX\Provider;
use App\Rules\CheckValidPhoneNumber;
use App\Traits\MetronetSmsTraits;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use App\Models\STD\AttendanceData;
use App\Models\Attendance\AttendenceMessage;
use App\Models\Convocation\StudentConvocation;
use App\Models\STD\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SmsController extends Controller
{
    use MetronetSmsTraits;

    public function test_sms()
    {

        try {
//            $providerArray = '01839115839';
//            $providerArray = Provider::active()->pluck('name_or_number')->toArray();

//            dd($providerArray);
//            $providerArray = Provider::whereRaw('LENGTH(prov) > 1')->pluck('prov')->toArray(); // alternative
//            $providerArray = '01839115794';
//            $providerArray = ['01839115794','01882839859','01839115839'];

            $mobileNumberWith88Prefix = '8801722711523';

            $content = 'Welcome to DIU IT Team. Congratulation sms is firing';

            $response = smsWithPBX::send('01839115794' , $mobileNumberWith88Prefix , $content);

//            return 'sms send';
            dd($response);

        }catch (\Exception $exception)
        {
            return response($exception->getMessage());
        }

    }

    public function convocation_image_sync()
    {
        $files = Storage::disk('attendance_info')->files();

        // return 
        $students_reg_from_convocation = StudentConvocation::whereNull('image_url')->pluck('reg_code_one','id');
 
        

        foreach ($students_reg_from_convocation as $convocation_id => $reg_no)

        {
            // return dd($convocation_id,$reg_no);
            $student_id = Student::where('REG_CODE', $reg_no)->value('id');
            
            $image = "student_profile_photo_{$student_id}.jpg";

            if(Storage::disk('image_path')->exists($image))
            {
                $get_image = Storage::disk('image_path')->get($image);

                Storage::disk('attendance_info')->put("{$convocation_id}.jpg", $get_image);

                // dd('Convocation Student Image retrieved '."{$convocation_id}.jpg");

            }else{
                $url = (env('RMS_API_URL').'/get_student_by_reg_code/'.$reg_no);

                $response = Curl::to($url)
                ->asJson(true)
                ->get();
    
                (($response['id']));
                // return $response;

            }
        }
    }

//    public function info()
//    {
//        $url = env('RMS_API_URL');
//
//        $batches_with_departments = Curl::to($url . '/get_active_batch/')->asJson(true)->get();
//
//        $batches = $batches_with_departments['batches'];
//
//        $departments = $batches_with_departments['departments'];
//
//        $courses = Curl::to($url . '/get_active_courses')->withData($departments)->asJson(true)->post();
//
//
//        $semesters = Curl::to($url . '/get_program_officer_nos')->asJson(true)->get();
//
//
//        $students = Curl::to($url . '/get_students')->asJson(true)->get();
//
//
//        $interval = AttendenceMessage::value('schedule');
//
//
//        $today = Carbon::now();
//
//        if ($interval == 'daily') {
//            $info['date'] = $time = $today->subDays(1)->format('Y-m-d');
//
//            $data['attendance'] = AttendanceData::with('relAttendanceReport')->where('date', $time)->get();
//
//        } elseif ($interval == 'monthly') {
//            $start_date = $today->subDays(30)->format('Y-m-d');
//            $end_date = Carbon::now()->subDays(1)->format('Y-m-d');
//
//            $info['date'] = $time = [$start_date, $end_date];
//
//            $data['attendance'] = AttendanceData::with('relAttendanceReport')->whereBetween('date', $time)->get();
//        } elseif ($interval == 'weekly') {
//            $start_date = $today->subDays(7)->format('Y-m-d');
//            $end_date = Carbon::now()->subDays(1)->format('Y-m-d');
//
//            $info['date'] = $time = [$start_date, $end_date];
//
//
//            $data['attendance'] = AttendanceData::with('relAttendanceReport')->whereBetween('date', $time)->get();
//        }
//
//        $attendance_with_absent = $data['attendance']->map(function ($item) use ($students) {
//
//            $present_students = (($item->relAttendanceReport)->pluck('student_id'))->toArray();
//
//            $all_students = collect($students)->where('batch_id', $item->batch_id)->pluck('id')->toArray();
//
//            $absent_students = array_values(array_diff($all_students, $present_students));
//
//            return [
//                'date' => $item->date,
//                'batch_id' => $item->batch_id,
//                'course_id' => $item->course_id,
//                'semester' => $item->semester,
//                'absent_students' => $absent_students
//            ];
//        });
//
//        $absent_student_rolls = $attendance_with_absent->pluck('absent_students');
//
//        $absents = collect(array_unique(call_user_func_array('array_merge', ($absent_student_rolls)->toArray())));
//
//
////        dd($absents->count());
//        $chunked_absent = array_chunk(($absents)->toArray(), 50);
//
//
//        foreach ($chunked_absent as $absent) {
//
//            $presentTime = time();
//
//
//            $campaign = new PbxCampaign();
//            $campaign->name = 'Attendance-' . $campaign->max('id');
//            $campaign->created_by = 333;
//            $campaign->count_mobile_number = count($absent);
//            $campaign->message = 'Attendance sms';
//            $campaign->is_custom_sms = 1;
//            $campaign->created_at = $presentTime;
//            $campaign->updated_at = $presentTime;
//            $campaign->save();
//
//
//            //            $job = new AttendanceSmsJob($absent, $attendance_with_absent, $students, $courses, $semesters, $campaign);
//            //            $this->dispatch($job);
//
//            $this->sendSms($absents, $attendance_with_absent, $students, $courses, $semesters, $campaign);
//        }
//
//    }

//    private function sendSms($absents, $attendance_with_absent, $students, $courses, $semesters, $campaign)
//    {
//        foreach ($absents as $roll) {
//            $sms_body[$roll] = [];
//
//            foreach ($attendance_with_absent as $student_data) {
//                $student_information = (collect($students)->where('id', $roll))->first();
//
//
//                if ($student_data['batch_id'] == $student_information['batch_id']) {
//                    $sms_body[$roll]['name'] = $student_information['name'];
//
//                    $course_code = (collect($courses)->where('id', $student_data['course_id']))->first();
//
//
//                    array_key_exists('absent_courses', $sms_body[$roll])
//                        ? $sms_body[$roll]['absent_courses'] .= ', ' . $course_code['code']
//                        : $sms_body[$roll]['absent_courses'] = $course_code['code'];
//
//                    array_key_exists('total_class_missed', $sms_body[$roll])
//                        ? $sms_body[$roll]['total_class_missed'] += 1
//                        : $sms_body[$roll]['total_class_missed'] = 1;
//
//                    $semester = (collect($semesters)->where('batch_id', $student_data['batch_id'])
//                        ->where('semester', $student_data['semester']))->first();
//
//                    $sms_body[$roll]['program_officer_no'] = $semester['program_officer']['mno1'];
//                    $sms_body[$roll]['phone_no'] = $student_information['phone_no'];
//                    $sms_body[$roll]['f_cellno'] = $student_information['f_cellno'];
//                    $sms_body[$roll]['g_cellno'] = $student_information['g_cellno'];
//
//                    $f_no['f_cellno'] = new CheckValidPhoneNumber();
//                    $g_no['g_cellno'] = new CheckValidPhoneNumber();
//
//                    if (Validator::make($sms_body[$roll], $f_no)->passes()) {
//                        $sms_body[$roll]['cell_no'] = $this->varifyPrefix($student_information['f_cellno']);
//                    } elseif (Validator::make($sms_body[$roll], $g_no)->passes()) {
//                        $sms_body[$roll]['cell_no'] = $this->varifyPrefix($student_information['g_cellno']);
//                    } else {
//                        $sms_body[$roll]['cell_no'] = $this->varifyPrefix($student_information['phone_no']);
//                    }
//
//
//                    unset($sms_body[$roll]['phone_no'], $sms_body[$roll]['f_cellno'], $sms_body[$roll]['g_cellno']);
//
//
//                }
//
//            }
//
//            $sms = "Dear guardian, {$sms_body[$roll]['name']} has missed {$sms_body[$roll]['total_class_missed']} classes of {$sms_body[$roll]['absent_courses']} courses in the last few days. For more details call DIU {$sms_body[$roll]['program_officer_no']}";
////            $sms = 'Dear guardian, ' . $sms_body[$roll]['name'] . ' has missed ' . $sms_body[$roll]['total_class_missed'] . ' classes of ' . $sms_body[$roll]['absent_courses'] . ' courses in the last few days. For more details call DIU ' . $sms_body[$roll]['program_officer_no'];
//
//
////            $providerArray = \App\Models\GOIP\Provider::active()->pluck('name_or_number')->toArray();
//
//            echo $sms;
//            $providerArray = Provider::whereRaw('LENGTH(prov) > 1')->pluck('prov')->toArray(); // alternative
//
//            // for pbx code
////            $providerCount = count($providerArray);
//            //            dd($providerArray, $providerCount);
//
//            $providerCounter = 0;
//
//
//            $mobileNumberCounter = 0;
//
//
//            // pbx or metrotel  (if compain running)
//            // supervisord
//            dispatch(new SendSmsJob($providerArray[$providerCounter], $sms_body[$roll]['cell_no'], $sms,
//                $campaign->id));
//
//        }
//    }
//
    public function schedule()
    {
        $schedule = AttendenceMessage::get()->pluck('schedule');
        return response()->json($schedule, 200);
    }

    public function sms_response($taskId)
    {
        return
        smsWithPBX::getQuery(null,$taskId);
    }


    public function varifyPrefix($number): string
    {
        //test contact
//        return '8801722711523';

        if (strpos($number, '+') === 0) {
            return substr($number, 1);
        }

        return '880' . substr($number, -10);
    }


    public function dailySms()
    {
        $today = Carbon::now();

        $time = $today->subDays(1)->format('Y-m-d');

        $attendance = AttendanceData::with('relAttendanceReport')->where('date', $time)->get();

        $this->smsJob($attendance);
    }


    public function weeklySms()
    {
        $today = Carbon::now();

        $start_date = $today->subDays(30)->format('Y-m-d');
        $end_date = Carbon::now()->subDays(1)->format('Y-m-d');

        $time = [$start_date, $end_date];

        $attendance = AttendanceData::with('relAttendanceReport')->whereBetween('date', $time)->get();


        $this->smsJob($attendance);
    }


    public function monthlySms()
    {
        $today = Carbon::now();

        $start_date = $today->subDays(7)->format('Y-m-d');
        $end_date = Carbon::now()->subDays(1)->format('Y-m-d');

        $time = [$start_date, $end_date];

        $attendance = AttendanceData::with('relAttendanceReport')->whereBetween('date', $time)->get();

        $this->smsJob($attendance);
    }

    private function smsJob($attendance)
    {
        $batches_in_attendance = ($attendance->pluck('batch_id'))->unique();


        $batches = $batches_in_attendance->chunk(15);


        foreach ($batches as $batch) {
            $this->findAbsentStudents($attendance, $batch);


//            $this->sendSmsTask($batch_wise_sms, $campaign);
        }
    }

    private function findAbsentStudents($attendance, $batches_in_attendance)
    {
        $url = env('RMS_API_URL');

//        $smses = [];


        foreach ($batches_in_attendance as $batch) {
            $semester = $attendance->where('batch_id', $batch)->first()->semester;

            if (empty($batch)) {
                return false;
            }

            $students = Curl::to($url . '/get_students_by_batch/' . $batch)->asJson(true)->get();

//            dd($students);
            if (empty($students)) {
                return false;
            }

            $batches_with_present_student = collect($attendance)->where('batch_id', $batch);

            $attendance_with_absent = $batches_with_present_student->map(function ($item) use ($students) {

                $present_students = (($item->relAttendanceReport)->pluck('student_id'))->toArray();

                $all_students = collect($students)->pluck('id')->toArray();

                $absent_students = array_values(array_diff($all_students, $present_students));

                return [
                    'course_code' => $item->course_code,
                    'absent_students' => $absent_students,
                ];
            });


//            array_push($smses,
                $this->generateSms($attendance_with_absent, $students, $batch, $semester);
//            $smses = ;

//            return $smses;
        }

//        return $smses;
    }

    private function getSmsNumber($info): string
    {
        $f_no['f_cellno'] = new CheckValidPhoneNumber();
        $g_no['g_cellno'] = new CheckValidPhoneNumber();

        if (Validator::make($info, $f_no)->passes()) {
            $sender_number = $this->varifyPrefix($info['f_cellno']);
        } elseif (Validator::make($info, $g_no)->passes()) {
            $sender_number = $this->varifyPrefix($info['g_cellno']);
        } else {
            $sender_number = $this->varifyPrefix($info['phone_no']);
        }

//        dump($sender_number);
        return $sender_number;
    }

    private function generateSms($attendance_with_absent, $students, $batch, $semester)
    {
        $url = env('RMS_API_URL');

        $program_offer_no = Curl::to($url . '/get_program_officer_by_semester_batch/' . $batch . '/' . $semester)->asJson
        (true)->get();

        $program_offer_no = collect($program_offer_no)->first()['mno1'];

        $course_wise_absence = $attendance_with_absent->pluck('absent_students');


        $absent_students = (collect($course_wise_absence)->flatten(1))->unique();

//        $sms = [];

        foreach ($absent_students as $student) {
            $total_class_missed = 0;
            $absent_courses = '';
            foreach ($attendance_with_absent as $info) {
                if (in_array($student, $info['absent_students'])) {
                    $total_class_missed++;

                    empty($absent_courses)
                        ? $absent_courses = $info['course_code'] :
                        $absent_courses .= ', ' . $info['course_code'];
                }

            }

            $student_info = collect($students)->where('id', $student)->first();


            $sms_number = $this->getSmsNumber($student_info);


            $sms[$sms_number] = 'Dear guardian, ' . trim($student_info['name']) . ' has missed ' . $total_class_missed . ' classes of '
                . $absent_courses . ' courses in the last few days. For more details call DIU ' . $program_offer_no;

        }


        $this->sendSmsTask($sms);
    }

    private function sendSmsTask($batch_wise_sms)
    {

        $pbx_busy = DB::table('jobs')->where('queue', 'campaign')->exists();

        if (!$pbx_busy) {
            $presentTime = time();

            $campaign = new PbxCampaign();
            $campaign->name = 'Attendance-' . $campaign->max('id');
            $campaign->created_by = 333;
            $campaign->count_mobile_number = count($batch_wise_sms);
            $campaign->message = 'Attendance sms';
            $campaign->is_custom_sms = 1;
            $campaign->created_at = $presentTime;
            $campaign->updated_at = $presentTime;
            $campaign->save();

            $providerCounter = 0;

            $providerArray = Provider::active()->pluck('name_or_number')->toArray();


            foreach ($batch_wise_sms as $key => $sms) {
                dispatch(new SendSmsJob($providerArray[$providerCounter], $key, $sms, $campaign->id));
            }

        } else {

            foreach ($batch_wise_sms as $key => $sms) {
//                dd('send sm with pbx');
//                dd($this->send_sms('8801794188835', $sms));  // test sms to my number
//                dd($this->send_sms('8801722711523', $sms));  // test sms to my number
                $this->send_sms($key, $sms);
            }
        }
    }
}

