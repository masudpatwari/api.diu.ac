<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Employee;
use Ixudra\Curl\Facades\Curl;

class ImprovementController extends Controller
{
    use RmsApiTraits;

    public function eligible_for_incourse(Request $request, int $examSchedule)
    {
        $id = $request->auth->ID;
        $result = $this->traits_eligible_for_incourse( $id , $examSchedule);
        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

    public function eligible_for_final(Request $request, int $examSchedule)
    {
        $id = $request->auth->ID;
        $result = $this->traits_eligible_for_final( $id , $examSchedule);
        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

//    public function eligible_for_final_test(Request $request, int $examSchedule)
//    {
//        $id = $request->auth->ID;
////        return
//        $result = $this->traits_eligible_for_final_test( $id , $examSchedule);
//        if (!empty($result)) {
//            return response()->json($result, 200);
//        }
//        return response()->json(NULL, 404);
//    }

    public function get_current_improvement_exam_schedule()
    {
        $result = $this->traits_get_current_improvement_exam_schedule();

        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

    public function get_applied_improvement_exam_schedule(Request $request)
    {
        $std_id = $request->auth->ID;

        $result = $this->traits_get_applied_improvement_exam_schedule($std_id);

        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

    public function get_improvement_marksheet_for_student(Request $request)
    {
        $input = [
            'ies_id'=> $request->selectedExamSchedule_id,
            'student_id' =>  $request->auth->ID

        ];
        $url = env('RMS_API_URL').'/get_improvement_marksheet_for_student';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->auth->ID;

        $std = $this->traits_get_student_by_id( $id );

//        dd($std

        $this->validate($request,
            [
                'course_id' => 'required|integer',
                'currentExamSchedule_id' => 'required|integer',
                'type' => 'required|in:incourse,final',
            ]
        );

		if( ! isset($std->campus_id)){
            return response()->json(['error'=> 'Campus Not Found!'], 400);
        }

        $course_array = [
            'student_id' => $id,
            'course_id' => $request->course_id,
            'campus_id' => $std->campus_id,
            'currentExamSchedule_id' => $request->currentExamSchedule_id,
            'type' => $request->type
        ];

        $url =env('RMS_API_URL').'/apply_improvement_request';
        $response = Curl::to($url)->withData($course_array)->returnResponseObject()->asJson(true)->post();
        return  response()->json($response->content, $response->status);
    }

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

    public function application(Request $request, $currentExamScheduleId, $type)
    {
        if(!isset($request->auth)){
            return response()->json(['error'=>'Authentication Fail. Login Again. '] , 400);
        }
        $std_id = $request->auth->ID;
        $token = $type . ' - '. md5($std_id);

        $url =env('RMS_API_URL') . "/get-improvement-application-data/$std_id/$currentExamScheduleId/$type";
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        $data = "";

        if ( $response->status == 200 ){
            $data =  $response->content['data'];
            $data['type'] = $type;
        }else{
            return response()->json(['error'=> ' No Application Found!'],400);
        }

        $file_path = storage_path('improvement_application/application_'.$std_id.'.pdf');
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $view = view('improvement_application/application', $data);
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->SetTitle('application_'.$token.'');
        $mpdf->WriteHTML(file_get_contents( storage_path('assets/improvement_application.css') ), 1);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view, 2);
        $mpdf->Output($file_path, 'F');
        return $mpdf->Output('application_'.$token.'', 'I');
    }

    public function getImprovementExamRoutine(Request $request, $examSheduleId = 3)
    {
        $std_id = $request->auth->ID;

        $url = env('RMS_API_URL') . "/get_improvement_exam_routine/$std_id/$examSheduleId";

        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        $data = "";
        if ( $response->status == 200 ){
            return $response->content['data'];
        }else{
            return response()->json(['error'=> $response->content['error']], 400);
        }
    }

    public function getImprovementExamSchedule()
    {
        $url = env('RMS_API_URL') . "/get_all_improvement_exam_schedule";
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        $data = "";
        if ( $response->status == 200 ){
            return $response->content['data'];
        }else{
            return response()->json(['error'=> $response->content['error']], 400);
        }
    }
}
