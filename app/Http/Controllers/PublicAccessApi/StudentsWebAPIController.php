<?php

namespace App\Http\Controllers\PublicAccessApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Transcript;
use App\Http\Resources\TranscriptVerificationResource;

class StudentsWebAPIController extends Controller
{
    use RmsApiTraits;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    
    public function __construct()
    {
        //
    }

    public function get_departments_array()
    {
        $result = [
            1 => "B.Sc. in Computer Science & Engineering",
            2 => "B.Sc. in Electrical, Electronics and Telecommunication Engineering",
            3 => "B.Sc. in Civil Engineering",
            4 => "Bachelor of Pharmacy (Hons.)",
            5 => "Bachelor of Business Administration",
            6 => "Bachelor of Education (B.Ed.)",
            7 => "B. A. (Hons.) in English",
            8 => "BSS (Hons.) in Sociology",
            9 => "LL.B. (Hons.)",
            10 => "LL.B (Pass)",
            11 => "LL.M.",
            12 => "M. A. in English",
            13 => "Master of Social Sciences in Sociology",
            14 => "Master of Human Rights Law",
            15 => "Master of Business Administration",
            16 => "Master of Education",
            17 => "Master of Computer Application",
            18 => "M.Sc. in Computer Science & Engineering",
        ];
        return response()->json($result, 201);
    }

    public function get_departments()
    {
        return $this->traits_get_departmsents();
    }

    public function get_batch_id_name( $department_id )
    {
        return $this->traits_get_batch_id_name( $department_id );
    }

    public function check_student(Request $request, $department_id, $batch_id, $reg_code, $roll_no, $phone_no )
    {
        $request->merge([
            'department_id' => ($department_id == '0') ? "" : $department_id,
            'batch_id' => ($batch_id == '0') ? "" : $batch_id,
            'registration_code' => ($reg_code == '0') ? "" : $reg_code,
            'roll_no' => ($roll_no == '0') ? "" : $roll_no,
            'phone_no' => ($phone_no == '0') ? "" : $phone_no,
        ]);


        $this->validate($request, [
            'department_id' => 'required',
            'batch_id' => 'required',
            'registration_code' => 'required',
            'roll_no' => 'required',
            'phone_no' => 'required',
        ]);
        
        return $this->traits_check_student( $department_id, $batch_id, $reg_code, $roll_no, $phone_no );
    }


    public function get_students_by_batch_id( $batch_id )
    {
        return $this->traits_get_students_by_batch_id( $batch_id );
    }


    /**
     * @param Request $request
     * @return TranscriptVerificationResource|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transcript_verification(Request $request)
    {
        $this->validate($request, 
            [
                'roll' => 'required|numeric',
                'session' => 'required',
                'reg_code' => 'required|exists:transcripts,regcode',
                'passing_year' => 'required|numeric',
            ]
        );

        $roll = $request->input('roll');
        $session = $request->input('session');
        $regcode = $request->input('reg_code');
        $passing_year = $request->input('passing_year');

        $transcripts = Transcript::where([ 'verified' => 1, 'roll' => $roll, 'session' => $session, 'regcode' => $regcode, 'passing_year' => $passing_year])->first();
        if (!empty($transcripts))
        {
            return new TranscriptVerificationResource($transcripts);
        }
        return response()->json(['error' => 'Transcript not found.'], 404);
    }

    public function transcript_download($filename, $token)
    {
        $filePath = storage_path('transcripts').'/'.$filename;

        if (md5($filename) == $token) {
            
            if (file_exists($filePath)) {
                $headers = [
                    'Content-Type' => mime_content_type( $filePath ),
                ];
                return response()->download( $filePath, $filename, $headers);
            }
        }
        return response()->json(NULL, 404);
    }
}
