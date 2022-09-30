<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\STD\Student;
use Ixudra\Curl\Facades\Curl;
use App\Employee;
use Illuminate\Support\Facades\Cache;

trait RmsApiTraits
{
    /*
     * rms get batch info by batch ids
     * @param array $ids
    */
    public static function rms_get_batch_info_by_ids(array $ids)
    {

        $url = env('RMS_API_URL') . '/rms-get-batch-info-by-ids';
        $response = Curl::to($url)
            ->withData($ids)
            ->returnResponseObject()
            ->asJson(true)
            ->post();
        if ($response->status == 200) {
            return $response->content;
        } else return false;
    }

    public static function ssl()
    {
        return stream_context_create(
            [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
    }

    public function traits_latest_foreign_students(array $ids)
    {
        if (count($ids) == 0) {
            return false;
        }
        $idsAsString = implode(",", $ids);

        $result = json_decode(
            @file_get_contents(env('RMS_API_URL') . '/latest-foreign-students?ids=' . $idsAsString,
                false,
                self::ssl())
            , true);

        if (!empty($result)) {
            return $result;
        }
        return false;

        //new
        /*if (Cache::has('rms_latest_foreign_students')) {

            $result = Cache::get('rms_latest_foreign_students');
            return response()->json($result, 201);
        }

        $idsAsString = implode(",", $ids);
        $data_result = json_decode(
            @file_get_contents(env('RMS_API_URL') . '/latest-foreign-students?ids=' . $idsAsString,
                false,
                self::ssl())
            , true);

        if (!empty($data_result)) {

            Cache::put('rms_latest_foreign_students', $data_result, 1440); //1440 minute = 1 day

            return response()->json($data_result, 201);
        }
        return response()->json(NULL, 404);*/
    }

    public function traits_get_departmsents()
    {

        if (Cache::has('rms_departments')) {

            $result = Cache::get('rms_departments');
            return response()->json($result, 201);
        }


        $data_result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_deptartments', false, self::ssl()));

        if (!empty($data_result)) {

            Cache::put('rms_departments', $data_result, 1440); //1440 minute = 1 day

            return response()->json($data_result, 201);
        }
        return response()->json(NULL, 404);
    }

    public function traits_get_ref_student_for_liaison_officer()
    {

        $liaisonOfficer = 2;
        $url = '' . env('RMS_API_URL') . '/get-ref-student/' . $liaisonOfficer;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        if ($response->status == 200) {
            return $response->content;
        }
        throw new \Exception("Student not found", 1);

    }


    public function traits_get_single_ref_student_for_liaison_officer(int $stdid)
    {

        $liaisonOfficer = 2;
        $url = '' . env('RMS_API_URL') . '/get-ref-single-student/' . $liaisonOfficer . '/' . $stdid;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        if ($response->status == 200) {
            return $response->content;
        }
        throw new \Exception("Student not found", 1);

    }

    public function traits_get_ref_student_for_liaison_student()
    {

        $liaisonStd = 3;// 3 = ref by std
        $url = '' . env('RMS_API_URL') . '/get-ref-student/' . $liaisonStd;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        if ($response->status == 200) {
            return $response->content;
        }

        throw new \Exception("Student not found", 1);

    }


    public function traits_get_single_ref_student_for_liaison_student(int $stdid)
    {

        $liaisonOfficer = 3;
        $url = '' . env('RMS_API_URL') . '/get-ref-single-student/' . $liaisonOfficer . '/' . $stdid;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        if ($response->status == 200) {
            return $response->content;
        }
        throw new \Exception("Student not found", 1);

    }


    public function rmsBatchWiseAccountsReportNonCovid($batchId)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get-batch-wise-account-info-non-covid/' . (int)$batchId, false, self::ssl()));

        $returnArray = [];

        if (!empty($result)) {

            foreach ($result as $array) {

                if (strlen($array->phone_no) > 10 &&
                    (
                        strlen($array->f_cellno) > 10 ||
                        strlen($array->m_cellno) > 10 ||
                        strlen($array->e_cellno) > 10 ||
                        strlen($array->g_cellno) > 10
                    )) {

                    $array->phone_no = '+88' . $array->phone_no;

                    if (strlen($array->f_cellno) > 10) {
                        $array->fme = '+88' . $array->f_cellno;
                    } elseif (strlen($array->m_cellno) > 10) {
                        $array->fme = '+88' . $array->m_cellno;
                    } elseif (strlen($array->g_cellno) > 10) {
                        $array->fme = '+88' . $array->g_cellno;
                    } elseif (strlen($array->e_cellno) > 10) {
                        $array->fme = '+88' . $array->e_cellno;
                    } else {
                        $array->fme = 'NF';
                    }

                } else {
                    $stdFromStdSite = Student::where('id', $array->id)->first();
                    if ($stdFromStdSite) {
                        // dd($stdFromStdSite );   
                        $array->phone_no = '+88' . $stdFromStdSite->PHONE_NO;

                        if ($stdFromStdSite->F_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->F_CELLNO;
                        } elseif ($stdFromStdSite->M_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->M_CELLNO;
                        } elseif ($stdFromStdSite->G_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->G_CELLNO;
                        } elseif ($stdFromStdSite->E_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->E_CELLNO;
                        } else {
                            $array->fme = 'NF';
                        }
                    }
                }


                $returnArray[] = $array;
            }


            return $returnArray;
        }
        return false;
    }

    public function rmsCovidAccountsReport($batchId)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get-batch-wise-account-info/' . $batchId, false, self::ssl()));

        $returnArray = [];

        if (!empty($result)) {

            // dd($result);

            foreach ($result as $array) {

                if (strlen($array->phone_no) > 10 &&
                    (
                        strlen($array->f_cellno) > 10 ||
                        strlen($array->m_cellno) > 10 ||
                        strlen($array->e_cellno) > 10 ||
                        strlen($array->g_cellno) > 10
                    )) {

                    $array->phone_no = '+88' . $array->phone_no;

                    if (strlen($array->f_cellno) > 10) {
                        $array->fme = '+88' . $array->f_cellno;
                    } elseif (strlen($array->m_cellno) > 10) {
                        $array->fme = '+88' . $array->m_cellno;
                    } elseif (strlen($array->g_cellno) > 10) {
                        $array->fme = '+88' . $array->g_cellno;
                    } elseif (strlen($array->e_cellno) > 10) {
                        $array->fme = '+88' . $array->e_cellno;
                    } else {
                        $array->fme = 'NF';
                    }

                } else {
                    $stdFromStdSite = Student::where('id', $array->id)->first();
                    if ($stdFromStdSite) {
                        // dd($stdFromStdSite );   
                        $array->phone_no = '+88' . $stdFromStdSite->PHONE_NO;

                        if ($stdFromStdSite->F_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->F_CELLNO;
                        } elseif ($stdFromStdSite->M_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->M_CELLNO;
                        } elseif ($stdFromStdSite->G_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->G_CELLNO;
                        } elseif ($stdFromStdSite->E_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->E_CELLNO;
                        } else {
                            $array->fme = 'NF';
                        }
                    }
                }


                $returnArray[] = $array;
            }


            return response()->json($returnArray, 200);
        }
        return response()->json(NULL, 404);
    }

    public function rmsCovidDiscountAsScholarship(Request $request, int $stdId, float $amount)
    {
        $office_email = Employee::findOrFail($request->auth->id)->office_email;

        $url = '' . env('RMS_API_URL') . '/covid-discount-as-scholarhip?std_id=' . $stdId . '&amount=' . $amount . '&office_email=' . $office_email;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        return response()->json($response->content, $response->status);
    }


    public function save_student_scholarship_as_liaison_officer(Request $request, int $stdId, float $amount, string $receipt_no)
    {
        $office_email = Employee::findOrFail($request->auth->id)->office_email;

        $data = [
            'std_id' => $stdId,
            'amount' => $amount,
            'office_email' => $office_email,
            'receipt_no' => $receipt_no,
        ];

        $url = '' . env('RMS_API_URL') . '/save-student-scholarship-as-liaison-officer';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)->post();

        return [
            'content' => $response->content,
            'status' => $response->status
        ];
    }


    public function traits_get_batch_id_name($department_id)
    {
        /* $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_batch_id_name/' . $department_id . '', false, self::ssl()));
         if (!empty($result)) {
             return response()->json($result, 201);
         }
         return response()->json(NULL, 404);*/


        if (Cache::has('rms_get_batch_id_name_' . $department_id)) {

            $result = Cache::get('rms_get_batch_id_name_' . $department_id);
            return response()->json($result, 201);
        }

        $data_result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_batch_id_name/' . $department_id . '', false, self::ssl()));

//        dd($data_result);

        if (!empty($data_result)) {

            Cache::put('rms_get_batch_id_name_' . $department_id, $data_result, 1440); //1440 minute = 1 day

            return response()->json($data_result, 201);
        }
        return response()->json(NULL, 404);
    }

    public function traits_get_students_by_batch_id($batch_id)
    {
        /*$result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_students_by_batch_id/' . $batch_id . '', false, self::ssl()));
        if (!empty($result->data)) {
            return $result->data;
        }
        return NULL;*/


        /*$response = Curl::to('https://rms.diu.ac/api/get_students_by_batch_id/480')->get();
        return $response;*/

        $url = env('RMS_API_URL') . '/get_students_by_batch_id/' . $batch_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content['data'];
        }
        return null;

//        return $result->error;
    }

    public function traits_get_student_by_id($std_id, $by_array = false)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_student_by_id/' . $std_id . '', false, self::ssl()), $by_array);
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }

    public function traits_get_student_by_reg_code($reg_code)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_student_by_reg_code/' . $reg_code . '', false, self::ssl()));
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }


    public function traits_check_student($department_id, $batch_id, $reg_code, $roll_no, $phone_no)
    {
        $exists = Student::where(['DEPARTMENT_ID' => $department_id, 'BATCH_ID' => $batch_id, 'REG_CODE' => $reg_code, 'ROLL_NO' => $roll_no, 'PHONE_NO' => $phone_no])->exists();
        if ($exists) {
            return response()->json(['exists' => $exists], 201);
        }

        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/check_student/' . $department_id . '/' . $batch_id . '/' . $reg_code . '/' . $roll_no . '/' . $phone_no . '', false, self::ssl()));
        if (!empty($result)) {
            return response()->json($result, 201);
        }
        return response()->json(['error' => 'Your account not found!'], 404);
    }


    public function traits_eligible_for_incourse($ora_std_uid, $examSchedule)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/eligible_for_incourse/' . $ora_std_uid . '/' . $examSchedule, false, self::ssl()));
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }


    public function traits_eligible_for_incourse_test($ora_std_uid, $examSchedule)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/eligible_for_incourse_test/' .
            $ora_std_uid . '/' . $examSchedule, false, self::ssl()));
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }

    public function traits_eligible_for_final($ora_std_uid, $examSchedule)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/eligible_for_final/' . $ora_std_uid . '/' . $examSchedule, false, self::ssl()));
        if (!empty($result)) {
            return $result;
        }


        return NULL;
    }

//    public function traits_eligible_for_final_test($ora_std_uid, $examSchedule)
//    {
////        dd($ora_std_uid, $examSchedule);
//        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/eligible_for_final_test/' . $ora_std_uid . '/' . $examSchedule, false, self::ssl()));
//        if (!empty($result)) {
//            return $result;
//        }
//
//        dd($result);
//
//        return NULL;
//    }

    public function traits_get_current_improvement_exam_schedule()
    {

        if (Cache::has('rms_get_current_improvement_exam_schedule')) {

            $result = Cache::get('rms_get_current_improvement_exam_schedule');

            return $result;

        }

        $result = json_decode(file_get_contents('' . env('RMS_API_URL') . '/get_current_improvement_exam_schedule', false, self::ssl()));

        if (!empty($result)) {
            Cache::put('rms_get_current_improvement_exam_schedule', $result, 700); //1440 minute = 1 day
            return $result;
        }
        return NULL;
    }

    public function traits_get_applied_improvement_exam_schedule($std_id)
    {
        $result = json_decode(file_get_contents('' . env('RMS_API_URL') . '/get_applied_improvement_exam_schedule/' . $std_id, false, self::ssl()));

        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }

    public function get_banks_all()
    {

        if (Cache::has('rms_get_banks')) {

            return $result = Cache::get('rms_get_banks');

        }

        $data_result = json_decode(file_get_contents('' . env('RMS_API_URL') . '/get_banks', false, self::ssl()));

        if (!empty($data_result)) {

            Cache::put('rms_get_banks', $data_result, 700); //1440 minute = 1 day
            return $data_result;
        }

        return NULL;
    }

    public function get_purpose_pay()
    {

        if (Cache::has('rms_get_purpose_pay')) {

            $result = Cache::get('rms_get_purpose_pay');
            return response()->json($result, 201);

        }

        $data_result = json_decode(file_get_contents('' . env('RMS_API_URL') . '/get-purpose-pay', false, self::ssl()));

        if (!empty($data_result)) {

            Cache::put('rms_get_purpose_pay', $data_result, 1440); //1440 minute = 1 day
            return response()->json($data_result, 201);

        }
        return response()->json(NULL, 404);

    }

    public function trait_getStudents()
    {
        $url = env('RMS_API_URL') . '/bank/students';
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        return response()->json($response->content, $response->status);
    }

    public function trait_getStudentDetail(Request $request)
    {
        $regcode = $request->input('regcode');

        $input = [
            'regcode' => $regcode,

        ];

        $url = env('RMS_API_URL') . '/bank/students';
        $response = Curl::to($url)->withData($input)
            ->returnResponseObject()
            ->asJson(true)
            ->post();
        return response()->json($response->content, $response->status);

    }


    public function student_account_info_summary($ora_uid)
    {

        $url = '' . env('RMS_API_URL') . '/student_account_info_summary/' . $ora_uid;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function student_account_info($ora_uid)
    {

        $url = env('RMS_API_URL') . '/student_account_info/' . $ora_uid;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;

    }

    public function student_fetch_all_course_by_student_id_and_semester($s_id, $semester)
    {
        /*$url = ''.env('RMS_API_URL').'/semester-course-list/'.$s_id. '/' .$semester;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        
        return response()->json($response->content, $response->status);*/


        $url = env('RMS_API_URL') . '/semester-course-list/' . $s_id . '/' . $semester;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        // return $response;
        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function student_provisional_transcript_marksheet_info_by_student_id($s_id)
    {
        $url = env('RMS_API_URL') . '/provisional-transcript-marksheet-info/' . $s_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();


        if ($response->status == 200) {
            return $response->content;
        }else
        {
            return $response;
        }

        return false;
    }


    public function traits_get_batch_details_by_batch_id($batch_id, $by_array = false)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_batch/' . $batch_id . '', false, self::ssl()), $by_array);
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }

    public function scholarshipReport($data)
    {
        $url = env('RMS_API_URL') . '/cashin-report';
        $input = [
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'purpose_pay_id' => $data['purpose_pay_id']
        ];
        $response = Curl::to($url)
            ->withData($input)
            ->returnResponseObject()
            ->asJson()
            ->get();
        return response()->json($response->content);

    }


    public function studentFetchSemesterLists($s_id)
    {
        $url = env('RMS_API_URL') . '/get-semester-list/' . $s_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function studentFetchCourseAndTeacherInfoBySemester($s_id, $semester)
    {

        $url = env('RMS_API_URL') . '/get-semester-teacher-list/' . $s_id . '/' . $semester;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function student_infos($student_id)
    {

        $url = env('RMS_API_URL') . '/get_student_by_id/' . $student_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;

    }


    public function studentInfoWithCompleteSemesterResult($student_id)
    {

        $url = env('RMS_API_URL') . '/student/' . $student_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();


        if ($response->status == 200) {
            return $response->content;
        }else{
            return $response;
        }

        return false;

    }




    public function studentInfoWithTestCompleteSemesterResult($student_id)
    {

        $url = env('RMS_API_URL') . '/student-test/' . $student_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();


        if ($response->status == 200) {
            return $response->content;
        }else{
            return $response;
        }

        return false;

    }


    public function bankInfo($bank_id)
    {
        $url = env('RMS_API_URL') . '/get-bank/' . $bank_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }


    public function purposeInfo($purpose_id)
    {
        $url = env('RMS_API_URL') . '/get-purpose-pay/' . $purpose_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function provisional_result($studentId)
    {
        $url = env('RMS_API_URL') . '/provisional_result/' . $studentId;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function studentInfoWithCompleteSemesterResultByRegCode($reg_code)
    {

        $url = env('RMS_API_URL') . '/student-report/' . $reg_code;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;

    }

    public function activeBatchForAdmission()
    {
        $url = env('RMS_API_URL') . '/admission/active-batch-for-admission/';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();
//dd($response);
        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function BatchForAdmission()
    {
        $url = env('RMS_API_URL') . '/admission/batch-for-admission/';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function activeBatchForAdmissionWiseStudentsList($batch_id)
    {
        $url = env('RMS_API_URL') . '/admission/batch-wise-students/' . $batch_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function activeBatchForAdmissionWiseUnverifiedStudentsList($batch_id)
    {
        $url = env('RMS_API_URL') . '/admission/batch-wise-unverified-students/' . $batch_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function shifts()
    {
        $url = env('RMS_API_URL') . '/shifts';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function groups()
    {
        $url = env('RMS_API_URL') . '/groups';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function religion()
    {
        $url = env('RMS_API_URL') . '/religion';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function countriesList()
    {
        $url = env('RMS_API_URL') . '/country';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function refereedByParents()
    {
        $url = env('RMS_API_URL') . '/admission/refereed-by-parent/index';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function refereedChildByParents($parent_id)
    {
        $url = env('RMS_API_URL') . '/admission/refereed-child-by-parent/' . $parent_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function activeBatchStudentStore($data)
    {
        $url = env('RMS_API_URL') . '/admission/active-batch-student-store';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();


    // dd($response);

        if ($response->status == 200) {
            return $response->content;
        }
        return false;

    }

    public function rmsCampus()
    {
        $url = env('RMS_API_URL') . '/campuss';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function rmsPaymentSystem()
    {
        $url = env('RMS_API_URL') . '/payment-system';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }


    public function activeBatchStore($data)
    {
        $url = env('RMS_API_URL') . '/admission/batch-store';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }


    public function unverifiedStudentRegCodeGenerateStore($data)
    {
        $url = env('RMS_API_URL') . '/admission/unverified-student-reg-code-generate';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function receiptNoCheck($recept_no)
    {
        $url = env('RMS_API_URL') . '/receipt-no-check/' . $recept_no;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }


    public function getStudentByRegCode($reg_code)
    {
        $url = env('RMS_API_URL') . '/get_student_by_reg_code/' . $reg_code;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public function fetchStudentSession()
    {
        $url = env('RMS_API_URL') . '/admission/student-session';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function storeStudentSession($data)
    {
        $url = env('RMS_API_URL') . '/admission/student-session';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function editStudentSession($id)
    {
        $url = env('RMS_API_URL') . '/admission/student-session/' . $id . '/edit';
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function updateStudentSession($data)
    {
        $url = env('RMS_API_URL') . '/admission/student-session-update';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }


    public function admissionSummery($data)
    {
        $url = env('RMS_API_URL') . '/admission/registration-summery';
        $input = [
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ];
        $response = Curl::to($url)
            ->withData($input)
            ->returnResponseObject()
            ->asJson()
            ->get();

            // dd($response);
        if ($response->status == 200) {
            return $response->content;
        }

        return false;

    }



    public function bapiCacheClear()
    {
        $url = env('RMS_API_URL') . '/cache-clear';

        $response = Curl::to($url)
            ->asJson(true)
            ->get();

        return true;
    }

    public function fetchDepartmentWiseInactiveBatch($data)
    {
        $url = env('RMS_API_URL') . '/admission/department-wise-inactive-batch/' . $data;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }
    public function fetchAdmissionMonthlyStudent($start,$end)
    {
        $url = env('RMS_API_URL') . '/admission/monthly-admission-student/' . $start.'/'.$end;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function reAdmissionStudent($data)
    {
        $url = env('RMS_API_URL') . '/admission/student-readmission';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function departmentWiseBatchRegCardStatus($department_id)
    {
        $url = env('RMS_API_URL') . '/admission/department-wise-batch-student-id-card-status/' . $department_id;

        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }


    public function batchWiseStudentIdCardStatusUpdate($data)
    {
        $url = env('RMS_API_URL') . '/admission/batch-wise-student-id-card-status-update';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function fullInfoStudentById($id)
    {
        $url = env('RMS_API_URL') . '/admission/student/' . $id;

        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function studentInfoUpdate($data)
    {
        $url = env('RMS_API_URL') . '/admission/student-update';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function studentEmailUpdate($data)
    {
        $url = env('RMS_API_URL') . '/admission/student-email-update';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }


    public function studentSearch($data)
    {
        $url = env('RMS_API_URL') . '/admission/student-filter/' . $data;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function studentPendingIdCard()
    {
        $url = env('RMS_API_URL') . '/admission/pending-id-card';

        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }


    public function studentPendingIdCardUpdate($data)
    {
        $url = env('RMS_API_URL') . '/admission/pending-id-card-update';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function batchIndex($page_number)
    {
        $url = env('RMS_API_URL') . '/admission/batch?page=' . $page_number;

        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function batchEdit($id)
    {
        $url = env('RMS_API_URL') . '/admission/batch/' . $id;

        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function batchDataUpdate($data)
    {
        $url = env('RMS_API_URL') . '/admission/batch-update';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function studentTransferApi($data)
    {
        $url = env('RMS_API_URL') . '/admission/student-transfer';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }

    public function cmsEmployeeSyncToErp($data)
    {
        $url = env('RMS_API_URL') . '/cms-employee-sync-to-erp';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)
            ->post();

        if ($response->status == 200 || $response->status == 202) {
            return $response->content;
        }

        return false;
    }


    public function traits_get_session_assign()
    {

        $url = '' . env('RMS_API_URL') . '/assign-session/';
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        if ($response->status == 200) {
            return $response->content;
        }
        return [$response];
        throw new \Exception("Session not found", 1);

    }
}

?>
