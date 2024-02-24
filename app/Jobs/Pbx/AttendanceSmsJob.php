<?php

namespace App\Jobs\Pbx;

use App\Jobs\Job;
use App\Models\PBX\Provider;
use App\Rules\CheckValidPhoneNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Jobs\Pbx\SendSmsJob;


class AttendanceSmsJob extends Job
{

    protected $absents, $attendance_with_absent, $students, $courses, $semesters, $campaign;
    /**
     * Create a new job instance.
     *
     * @param  App\Models\Podcast  $podcast
     * @return void
     */
    public function __construct($absents, $attendance_with_absent, $students, $courses, $semesters, $campaign)
    {
        $this->attendance_with_absent   = $attendance_with_absent;
        $this->semesters                = $semesters;
        $this->students                 = $students;
        $this->absents                  = $absents;
        $this->courses                  = $courses;
        $this->campaign                 = $campaign;
    }

    /**
     * Execute the job.
     *
     * @param  App\Services\AudioProcessor  $processor
     * @return void
     */
    public function handle()
    {
        foreach ($this->absents as $roll) {
            $sms_body[$roll] = [];

            foreach ($this->attendance_with_absent as $student_data) {
                $student_information = (collect($this->students)->where('id', $roll))->first();

                if ($student_data['batch_id'] == $student_information['batch_id']) {
                    $sms_body[$roll]['name'] = $student_information['name'];
                    $sms_body[$roll]['batch_id'] = $student_information['batch_id'];

                    $course_code = (collect($this->courses)->where('id', $student_data['course_id']))->first();


                    array_key_exists('absent_courses', $sms_body[$roll])
                        ? $sms_body[$roll]['absent_courses'] .= ', ' . $course_code['code']
                        : $sms_body[$roll]['absent_courses'] = $course_code['code'];

                    array_key_exists('total_class_missed', $sms_body[$roll])
                        ? $sms_body[$roll]['total_class_missed'] += 1
                        : $sms_body[$roll]['total_class_missed'] = 1;

                    $semester = (collect($this->semesters)->where('batch_id', $student_data['batch_id'])
                        ->where('semester', $student_data['semester']))->first();

                    $sms_body[$roll]['program_officer_no'] = $semester['program_officer']['mno1'];
                    $sms_body[$roll]['phone_no'] = $student_information['phone_no'];
                    $sms_body[$roll]['f_cellno'] = $student_information['f_cellno'];
                    $sms_body[$roll]['g_cellno'] = $student_information['g_cellno'];

                    $f_no['f_cellno'] = new CheckValidPhoneNumber();
                    $g_no['g_cellno'] = new CheckValidPhoneNumber();

                    if (Validator::make($sms_body[$roll], $f_no)->passes()) {
                        $sms_body[$roll]['cell_no'] = $this->varifyPrefix($student_information['f_cellno']);
                    } elseif (Validator::make($sms_body[$roll], $g_no)->passes()) {
                        $sms_body[$roll]['cell_no'] = $this->varifyPrefix($student_information['g_cellno']);
                    } else {
                        $sms_body[$roll]['cell_no'] = $this->varifyPrefix($student_information['phone_no']);

                    }


                    unset($sms_body[$roll]['phone_no'], $sms_body[$roll]['f_cellno'], $sms_body[$roll]['g_cellno']);


                }


            }

            $sms = 'Dear guardian, ' . $sms_body[$roll]['name'] . ' has missed ' . $sms_body[$roll]['total_class_missed'] . ' classes of ' . $sms_body[$roll]['absent_courses'] . ' courses in the last few days. For more details call DIU ' . $sms_body[$roll]['program_officer_no'];

//            Storage::disk('attendance_info')->append('sms_info.txt', $sms);  // temporary check sms gone or not
//            $providerArray = \App\Models\GOIP\Provider::active()->pluck('name_or_number')->toArray();
//                        dd($providerArray);
//            echo $sms;
            $providerArray = Provider::whereRaw('LENGTH(prov) > 1')->pluck('prov')->toArray(); // alternative
            // for pbx code
            $providerCount = count($providerArray);
            //            dd($providerArray, $providerCount);
            $providerCounter = 0;


            $mobileNumberCounter = 0;

//            $date = strtotime(Carbon::now());

            //            $delayTime = $date + ($mobileNumberCounter);

            //            $job = (new SendSmsJob($providerArray[$providerCounter], trim($sms_body[$roll]['cell_no']), $sms))
            //                ->onQueue('attendance_sms')
            //                ->delay($delayTime - time());
            //
            //            $this->dispatch($job);

            //            dispatch(new SendSmsJob(['8801939851063', '8801882839861', '8801882839859', '8801302690346', '8801302690347', '8801648172830'],
            //                $sms_body[$roll]['cell_no'],
            //                $sms, $this->campaign->id));
            // pbx or metrotel  (if compain running)
            // supervisord
            dispatch(new SendSmsJob($providerArray[$providerCounter], $sms_body[$roll]['cell_no'], $sms));

        }
    }



    public function varifyPrefix($number): string
    {
        //test contact
        return '8801722711523';

        if (strpos($number, '88') !== 0) {
            return '88' . $number;
        } else {
            return $number;
        }
    }



}
