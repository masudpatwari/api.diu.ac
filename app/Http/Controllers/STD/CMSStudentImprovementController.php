<?php

namespace App\Http\Controllers\STD;

use App\Traits\MetronetSmsTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Employee;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;

class CMSStudentImprovementController extends Controller
{
    use RmsApiTraits;
    use MetronetSmsTraits;

    public function get_current_improvement_exam_schedule_for_cms()
    {
        $result = $this->traits_get_current_improvement_exam_schedule();

        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

    public function get_student_for_payment(Request $request)
    {
        $url = env('RMS_API_URL').'/get_student_for_payment';
        $response = Curl::to($url)->withData($request->all())->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);
    }

    public function get_student_for_payment_test(Request $request)
    {
        $url = env('RMS_API_URL').'/get_student_for_payment';
        $response = Curl::to($url)->withData($request->all())->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);
    }
    
    public function get_banks()
    {
        return $result = $this->get_banks_all();

        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

    public function make_improvement_payment_complete(Request $request)
    {
        if(isset($request->due_payment))
        {
            $total_payable = -($request->input('due_payment'));
        }else
        {
            $total_payable = $request->total_payable;
        }

        $email = NULL;
        $id = $request->auth->id;
        $employee = Employee::where('id', $id)->first();
        if (!empty($employee)) {
            $email = $employee->office_email;
        }

        if (empty($email)) {
            return response()->json(['error'=> 'Email not found. Please update your email'], 400);
        }
        $array = [
            'bank_id' => $request->input('bank_id'),
            'bank_payment_date' => $request->input('bank_payment_date'),
            'receipt_no' => $request->input('receipt_no'),
            'invoice_number' => $request->input('invoice_number'),
            'total_cost' => $request->input('total_cost'),
            'total_payable' => $total_payable,
            'discount' => $request->input('discount'),
            'note' => $request->input('note'),
            'ies_id' => $request->input('ies_id'),
            'reg_code' => $request->input('reg_code'),
            'employee_email' => $email,
            'type' => $request->input('type'),
        ];

        $url = env('RMS_API_URL').'/make_improvement_payment_complete';
        $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

        if ($request->input('student_id')){
            $this->sendStudentSmsForFeeCollection($request->input('student_id'), $total_payable);
//            $this->sendStudentSmsForFeeCollection($request->input('student_id'), $request->input('total_payable'));
        }
        return response()->json($response->content, $response->status);
    }

    public function get_courses_for_improvement_apply(Request $request)
    {
        $ies_id = $request->ies_id;
        $reg_code = $request->reg_code;
        $type = $request->type;


        $student = $this->traits_get_student_by_reg_code( $reg_code );
        if (empty($student)) {
            return response()->json(['error'=> 'Student not found'], 400);
        }

        if ($type == 'incourse') {
            $result = $this->traits_eligible_for_incourse( $student->id , $ies_id);
        }

        if ($type == 'final') {
            $result = $this->traits_eligible_for_final( $student->id , $ies_id);
        }
        if (!empty($result)) {
            $data['student'] = $student;
            $data['eligible_courses'] = $result;
            return response()->json($data, 200);
        }
        return response()->json(['error' => 'No available course for this student.'], 404);
    }

    public function get_courses_for_improvement_apply_test(Request $request)
    {
        $ies_id = 78;
        $reg_code = 'CS-E-78-19-110927';
        $type = 'incourse';


        $student = $this->traits_get_student_by_reg_code( $reg_code );
        if (empty($student)) {
            return response()->json(['error'=> 'Student not found'], 400);
        }

        if ($type == 'incourse') {
            $result = $this->traits_eligible_for_incourse_test( $student->id , $ies_id);
        }

        if ($type == 'final') {
            $result = $this->traits_eligible_for_final( $student->id , $ies_id);
        }
//        dd($request->all(), $student, $result);
        if (!empty($result)) {
            $data['student'] = $student;
            $data['eligible_courses'] = $result;
            return response()->json($data, 200);
        }
        return response()->json(['error' => 'No available course for this student.'], 404);
    }

    public function store(Request $request)
    {
        $ies_id = $request->ies_id;
        $reg_code = $request->reg_code;
        $type = $request->type;
        $apply_course_id = $request->apply_course_id;
        $remove_course_id = $request->remove_course_id;


        $student = $this->traits_get_student_by_reg_code( $reg_code );
        if (empty($student)) {
            return response()->json(['error'=> 'Student not found'], 400);
        }

        $course_array = [
            'student_id' => $student->id,
            'campus_id' => $student->campus_id,
            'currentExamSchedule_id' => $ies_id,
            'type' => $type
        ];

        if (!empty($apply_course_id)) {
            $course_array['course_id'] = $apply_course_id;
            $url = env('RMS_API_URL').'/apply_improvement_request';
        }

        if (!empty($remove_course_id)) {
            $course_array['course_id'] = $remove_course_id;
            $url = env('RMS_API_URL').'/cancel_improvement_request';
        }
        $response = Curl::to($url)->withData($course_array)->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->auth->ID;

        $this->validate($request, 
            [
                'course_id' => 'required|integer',
                'currentExamSchedule_id' => 'required|integer',
                'type' => 'required|in:incourse,final',
            ]
        );
        $std = $this->traits_get_student_by_id( $id );

        $course_array = [
            'student_id' => $id,
            'course_id' => $request->course_id,
            'campus_id' => $std->campus_id,
            'currentExamSchedule_id' => $request->currentExamSchedule_id,
            'type' => $request->type
        ];

        $url =env('RMS_API_URL').'/cancel_improvement_request';
        $response = Curl::to($url)->withData($course_array)->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download_improvement_admit_card(Request $request, $reg_code, $ies_id, $type)
    {

        $url = env('RMS_API_URL').'/get_improvement_admit_card';
        $array = [
            'reg_code' => $reg_code,
            'ies_id' => $ies_id,
            'type' => $type,
        ];
        $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

        $data = "";
        if ( $response->status == 200 ){
            $data =  $response->content['data'];
            $data['type'] = $type;
            $data['exam_start_date'] = (!empty($data['improvement_exam_info']['exam_start_date'])) ? date('d F Y', strtotime($data['improvement_exam_info']['exam_start_date'])) : NULL;
        }else{
            return response()->json(['error'=> $response->content['error']], 400);
        }
        
        $student_id = $data['id'];
        $token = md5($student_id);
        
        $file_path = storage_path('admit_cards/'.$type.'_admit_card_improvement'.$student_id.'.pdf');
        $view = view('admit_cards/improvement_admit_card', $data);
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->SetTitle($type.'_admit_card_improvement'.$token.'');
        $mpdf->WriteHTML(file_get_contents( storage_path('assets/improvement_admit_card.css') ), 1);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view, 2);
        $mpdf->Output($file_path, 'F');
        return $mpdf->Output($type.'_admit_card_improvement'.$token.'', 'I');
    }

    public function application(Request $request, $reg_code, $currentExamScheduleId, $type)
    {
        if(!isset($request->auth)){
            return response()->json(['error'=>'Authentication Fail. Login Again. '] , 400);
        }

        $url =env('RMS_API_URL') . "/get-improvement-application-data-for-cms/$reg_code/$currentExamScheduleId/$type";
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        $data = "";
        if ( $response->status == 200 ){
            $data =  $response->content['data'];
            $data['type'] = $type;
        }else{
            return response()->json(['error'=> $response->content['error']], 400);
        }
        $student_id = $data['id'];
        $token = md5($student_id);

        $file_path = storage_path('improvement_application/application_'.$student_id.'.pdf');
        $view = view('improvement_application/application', $data);
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->SetTitle('application_'.$token.'');
        $mpdf->WriteHTML(file_get_contents( storage_path('assets/improvement_application.css') ), 1);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view, 2);
        $mpdf->Output($file_path, 'F');
        return $mpdf->Output('application_'.$token.'', 'I');
    }

    public function sendStudentSmsForFeeCollection($student_id, $total_payable)
    {
        $student = $this->traits_get_student_by_id($student_id);

        $message = "Dear {$student->name} Received TK. {$total_payable}/- as improvement fee DIU";
        $this->send_sms($student->phone_no, $message);
    }
}
