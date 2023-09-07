<?php

namespace App\Http\Controllers\STD;

use App\Models\STD\TeacherServiceFeedback;
use App\Traits\RmsApiTraits;
use App\Traits\MetronetSmsTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\Student;
use App\Models\Tolet\BloodDonate;
use App\Models\HMS\Hostel;
use App\Rules\CheckStrongPassword;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentEditResource;
use App\Http\Resources\StudentProfileResource;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use App\Employee;
use Carbon\Carbon;
use LaravelQRCode\Facades\QRCode;
use phpDocumentor\Reflection\Types\Null_;

class StudentsController extends Controller
{
    use RmsApiTraits, MetronetSmsTraits;



    public static function ssl()
    {
        return stream_context_create(
            [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = Student::orderBy('id', 'desc')->get();
        if (!empty($students)) {
            return StudentResource::collection($students);
        }
        return response()->json(NULL, 404);
    }

    public function all(Request $request, $query)
    {
        $student = Student::where('NAME',  $query)
            ->orWhere('REG_CODE', $query)
            ->orWhere('REG_CODE', 'LIKE', "%{$query}")
            ->first();

        if (!empty($student)) {

            $data['student']    = $student;

            if ($student->GENDER == 'M') {
                $data['hostel']     = Hostel::where('type', 'boys')->get();
            } elseif ($student->GENDER == 'F') {
                $data['hostel']     = Hostel::where('type', 'girls')->get();
            }

            return response()->json($data);
        }
        return response()->json(NULL, 404);
    }

    public function info($id)
    {
        $student = Student::find($id);
        // $students = Student::where('NAME',  'LIKE', "%{$info}%")
        //                     ->orWhere('REG_CODE',   'LIKE', "%{$info}%")
        //                     ->take(25)
        //                     ->orderBy('id', 'desc')
        // ->get();
        if (!empty($student)) {
            return response()->json($student);
        }
        return response()->json(NULL, 404);
    }

    public function show(Request $request)
    {
        $student = Student::with(['relStudentEducation' => function ($query) {
            $query->orderBy('id', 'desc');
        }])->whereId($request->auth->ID)->first();
        return response()->json(new StudentProfileResource($student), 200);
    }

    public function public_profile($slug_name = null)
    {
        if (empty($slug_name)) {
            return response()->json(NULL, 400);
        }
        $student = Student::with(['relStudentEducation' => function ($query) {
            $query->orderBy('id', 'desc');
        }])->where('slug_name', $slug_name)->first();
        if (!empty($student)) {
            return response()->json(new StudentProfileResource($student), 200);
        }
        return response()->json(['error' => 'Account not found'], 400);
    }


    public function upload_profile_photo(Request $request)
    {
        $id = $request->auth->ID;
        $this->validate(
            $request,
            [
                'profile_photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
            ]
        );
        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            $file = $request->file('profile_photo');
            $extention = strtolower($file->getClientOriginalExtension());
            $filename = 'images/' . 'student_profile_photo_' . $id . '.' . $extention;
            try {
                DB::beginTransaction();
                $request->file('profile_photo')->move(storage_path('/images'), $filename);

                Student::where('id', $id)->update([
                    'profile_photo' => $filename
                ]);

                DB::commit();
                return response()->json(['success' => 'Profile photo upload Successfull.'], 201);
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(['error' => 'Profile photo upload Failed.'], 400);
            }
        }
        return response()->json(['error' => 'Profile photo upload Failed.'], 400);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function profile_update_personal(Request $request)
    {

        $id = $request->auth->ID;
        $this->validate(
            $request,
            [
                'name' => ['required', 'string', 'max:40'],
                'phone_no' => ['required'],
                'slug_name' => ['required', 'string', 'max:40', 'unique:std.student,slug_name,' . $id],
                'site_tag' => ['required', 'string', 'max:100'],
                'gender' => ['required', 'in:M,F'],
                'blood_group' => ['required', 'in:O+,O-,A+,A-,B+,B-,AB+,AB-'],
                'dob' => ['required', 'date_format:Y-m-d'],
                'birth_place' => ['required', 'string', 'max:100'],
                'parmanent_address' => ['required', 'string', 'max:200'],
                'mailing_address' => ['required', 'string', 'max:200'],
                'nationality' => ['required', 'string', 'max:30'],
                'marital_status' => ['required', 'in:Married,Single,Widowed,Divorced'],
                'birth_or_nid_no' => ['nullable', 'string', 'max:50'],
                'father_name' => ['required', 'string', 'max:30'],
                'father_cellno' => ['required', 'string', 'max:15'],
                'father_occupation' => ['required', 'string', 'max:30'],
                'father_nid_no' => ['nullable', 'string', 'max:50'],
                'mother_name' => ['required', 'string', 'max:30'],
                'mother_cellno' => ['required', 'string', 'max:15'],
                'mother_occupation' => ['required', 'string', 'max:30'],
                'mother_nid_no' => ['nullable', 'string', 'max:50'],
                'guardian_name' => ['required', 'string', 'max:30'],
                'guardian_cellno' => ['required', 'string', 'max:15'],
                'guardian_occupation' => ['required', 'string', 'max:30'],
                'emergency_name' => ['required', 'string', 'max:30'],
                'emergency_cellno' => ['required', 'string', 'max:15'],
                'emergency_occupation' => ['required', 'string', 'max:30'],
                'emergency_address' => ['required', 'string', 'max:200'],
                'emergency_relation' => ['required', 'string', 'max:20'],
                'show_profile_publicly' => ['required', 'in:0,1'],
                'about_me' => ['required', 'string', 'max:500'],
            ]
        );

        try {

            DB::transaction(function () use ($request, $id) {
                $slug = str_replace([".", " ", "(", ")", "-", "@"], [""], strtolower($request->slug_name));
                $student = Student::where('id', $id)->update([
                    'NAME' => $request->name,
                    'PHONE_NO' => $request->phone_no,
                    'slug_name' => $slug,
                    'site_tag' => $request->site_tag,
                    'GENDER' => $request->gender,
                    'BLOOD_GROUP' => $request->blood_group,
                    'DOB' => $request->dob,
                    'BIRTH_PLACE' => $request->birth_place,
                    'PARMANENT_ADD' => $request->parmanent_address,
                    'MAILING_ADD' => $request->mailing_address,
                    'NATIONALITY' => $request->nationality,
                    'MARITAL_STATUS' => $request->marital_status,
                    'STD_BIRTH_OR_NID_NO' => $request->birth_or_nid_no,
                    'F_NAME' => $request->father_name,
                    'F_CELLNO' => $request->father_cellno,
                    'F_OCCU' => $request->father_occupation,
                    'FATHER_NID_NO' => $request->father_nid_no,
                    'M_NAME' => $request->mother_name,
                    'M_CELLNO' => $request->mother_cellno,
                    'M_OCCU' => $request->mother_occupation,
                    'MOTHER_NID_NO' => $request->mother_nid_no,
                    'G_NAME' => $request->guardian_name,
                    'G_CELLNO' => $request->guardian_cellno,
                    'G_OCCU' => $request->guardian_occupation,
                    'E_NAME' => $request->emergency_name,
                    'E_CELLNO' => $request->emergency_cellno,
                    'E_OCCU' => $request->emergency_occupation,
                    'E_ADDRESS' => $request->emergency_address,
                    'E_RELATION' => $request->emergency_relation,
                    'show_profile_publicly' => $request->show_profile_publicly,
                    'about_me' => $request->about_me,
                ]);
            });

            return response()->json(['success' => 'Update Successfull.'], 201);
        } catch (\Exception $e) {

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['error' => 'Update Failed.'], 400);
        }
    }

    public function profile_update_social(Request $request)
    {
        return $request->all();
    }

    public function profile_upload_cv(Request $request)
    {
        $id = $request->auth->ID;
        $this->validate(
            $request,
            [
                'upload_cv_file' => ['nullable', 'mimes:pdf', 'max:1024'],
            ]
        );
        if ($request->hasFile('upload_cv_file') && $request->file('upload_cv_file')->isValid()) {
            $file = $request->file('upload_cv_file');
            $extention = strtolower($file->getClientOriginalExtension());
            $filename = 'students_cv/' . 'cv_' . $id . '.' . $extention;
            try {
                DB::beginTransaction();
                $request->file('upload_cv_file')->move(storage_path('/students_cv'), $filename);
                DB::commit();
                return response()->json(['success' => 'CV upload Successfull.'], 201);
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(['error' => 'CV upload Failed.'], 400);
            }
        }
        return response()->json(['error' => 'CV upload Failed.'], 400);
    }

    public function profile_download_cv($slug_name = null)
    {
        if (empty($slug_name)) {
            return response()->json(NULL, 400);
        }
        $student = Student::where('slug_name', $slug_name)->first();

        if (!$student) {
            return response()->json(['error' => 'Account not found'], 400);
        }


        $path = storage_path('students_cv/');

        $filename = 'cv_' . $student->ID . '.pdf';

        if (file_exists($path . $filename)) {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response()->download($path . '/' . $filename, $student->NAME . ".pdf", $headers);
        }
        return response()->json(['error' => 'File Not Found.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }

    public function change_password(Request $request)
    {
        $this->validate(
            $request,
            [
                'current_password' => ['required', 'exists:std.student,password'],
                'password' => ['required', new CheckStrongPassword, 'confirmed'],
                'password_confirmation' => 'required',
            ]
        );

        $std = Student::whereId($request->auth->ID)->first();

        $this->validate($request,[
            'email' => 'unique:std.users,email,'.$std->id
        ]);

        if($std) {
            DB::connection('std')->table('student')->where('ID', $std->ID)->update([
                    'PASSWORD' => $request->input('password')]
            );
//            $std->update([
//                'password' => $request->password,
//            ]);
        }
        return response()->json(['message' => 'Password Changed.'], 200);
    }

    public function provisional_result($ora_uid)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/student_account_info_summary/' . $ora_uid . '', false, self::ssl()));

        if (!empty($result)) {

            $total_current_due = collect($result)['summary']->total_current_due;

            // if ( $total_current_due < 2000) { // if total current due is less then 2000 then result will show.

            $result_provisional = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/provisional_result/' . $ora_uid . '', false, self::ssl()));

            if (!empty($result_provisional)) {
                return response()->json($result_provisional, 200);
            }
            return response()->json(['message' => 'Result not found!'], 400);

            // }else{
            //     return response()->json(['message'=>'Clear due! To show result due < 2000 TK'], 400);
            // }

        } else {
            return response()->json(['message' => 'Account summary not found!'], 400);
        }
    }

    public function student_account_info($ora_uid)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/student_account_info/' . $ora_uid . '', false, self::ssl()));
        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

    public function student_account_info_summary($ora_uid)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/student_account_info_summary/' . $ora_uid . '', false, self::ssl()));
        //        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/student_account_info_summary/' . $ora_uid . '', false, self::ssl()));
        if (!empty($result)) {
            return response()->json($result, 200);
        }
        return response()->json(NULL, 404);
    }

    public function student_batch_mate($ora_uid)
    {
        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/batch-mate/' . $ora_uid . '', false, self::ssl()));
        if (!empty($result)) {
            return response()->json($result, 201);
        }
        return response()->json(NULL, 404);
    }

    public function change_profile_visibility(Request $request)
    {
        $std = Student::where('ID', $request->auth->ID)->first();

        $this->validate($request,[
            'email' => 'unique:std.users,email,'.$std->id
        ]);

        if($std){
            $std->update([
                'show_profile_publicly' => $std->show_profile_publicly == '1' ? '0' : '1'
            ]);
        }

        $message = $std->show_profile_publicly == '1' ? 'to Private' : 'to Public';
        return response()->json(['message' => 'Visibility Changed ' . $message], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search_by_reg_code(Request $request)
    {

        $this->validate(
            $request,
            [
                'reg_code' => ['required'],
            ]
        );

        $reg_code = $request->reg_code;

        $student = Student::where('REG_CODE', $reg_code)->first();

        if (!$student) {
            return response()->json(['error' => 'Student Not found!'], 400);
        }

        return new StudentProfileResource($student);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function change_current_email(Request $request)
    {

        $this->validate(
            $request,
            [
                'reg_code' => ['required'],
                'current_email' => ['required', 'email'],
                'to_email' => 'required|email',
            ]
        );

        $reg_code = $request->reg_code;
        $current_email = $request->current_email;
        $to_email = $request->to_email;

         $student = DB::connection('std')->table("student")->where('REG_CODE', $reg_code)->where('EMAIL',
             $current_email)
             ->first();

        if (!$student) {
            return response()->json(['error' => 'Student Not found with Reg. Code and Email!'], 400);
        }

//        $this->validate($request,[
//            'email' => 'unique:std.users,email,'.$student->id
//        ]);
        DB::connection('std')->table("student")->where('REG_CODE', $reg_code)->where('EMAIL',
            $current_email)
            ->update([
                'email' => trim($to_email)
            ]);
//        $student->update([
//            'email' => $to_email
//        ]);

        //        return $student;
        return response()->json(['message' => 'Student Email Change from:' . $current_email . ' to : ' . $to_email], 200);
    }

    public function update_ct_students_actual_fee(Request $request)
    {
        $this->validate(
            $request,
            [
                'ids.*' => 'required|integer',
                'department_id' => 'required|integer',
                'batch_id' => 'required|integer',
                'actual_fee' => 'required|integer',
                'no_of_semester' => 'required|integer',
                'payment_from_semester' => 'required|integer',
            ]
        );

        $ids = $request->ids;
        $actual_fee = $request->actual_fee;
        $no_of_semester = $request->no_of_semester;
        $payment_from_semester = $request->payment_from_semester;

        if (empty($ids)) {
            return response()->json(['error' => 'Please select an student'], 400);
        }

        $input = [
            'students' => $ids,
            'actual_fee' => $actual_fee,
            'no_of_semester' => $no_of_semester,
            'payment_from_semester' => $payment_from_semester,
        ];
        $url = env('RMS_API_URL') . '/update-ct-students-actual-fee-and-semester-n-paymenet-from-semseter';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->put();
        return response()->json($response->content, $response->status);
    }

    public function update_students_actual_fee(Request $request)
    {
        $this->validate(
            $request,
            [
                'ids.*' => 'required|integer',
                'department_id' => 'required|integer',
                'batch_id' => 'required|integer',
                'actual_fee' => 'required|integer',
                'no_of_semester' => 'required|integer',
            ]
        );
        $ids = $request->ids;
        $actual_fee = $request->actual_fee;
        $no_of_semester = $request->no_of_semester;

        if (empty($ids)) {
            return response()->json(['error' => 'Please select an student'], 400);
        }

        $input = [
            'students' => $ids,
            'actual_fee' => $actual_fee,
            'no_of_semester' => $no_of_semester,

        ];
        $url = env('RMS_API_URL') . '/update-students-actual-fee-and-number-of-semester';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->put();
        return response()->json($response->content, $response->status);
    }

    public function applyExtraFeeOnStudents(Request $request)
    {
        $this->validate(
            $request,
            [
                'ids.*' => 'required|integer',
                'department_id' => 'required|integer',
                'batch_id' => 'required|integer',
                'extra_fee' => 'required|integer',
                'purpose_id' => 'required|integer',
                'note' => 'required',
            ]
        );
        $ids = $request->ids;
        $extra_fee = $request->extra_fee;
        $purpose_id = $request->purpose_id;
        $note = $request->note;

        if (empty($ids)) {
            return response()->json(['message' => 'Please select an student'], 400);
        }

        $input = [
            'students' => $ids,
            'extra_fee' => $extra_fee,
            'purpose_id' => $purpose_id,
            'note' => $note,
            'office_email' => Employee::find($request->auth->id)->office_email,
        ];

        $url = env('RMS_API_URL') . '/apply-extra-fee-on-students';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->put();
        return response()->json($response->content, $response->status);
    }

    public function semesterList($student_id)
    {
        return $this->studentFetchSemesterLists($student_id);
    }

    public function teacherAndCourseLists($student_id, $semester)
    {
        return $this->studentFetchCourseAndTeacherInfoBySemester($student_id, $semester);
    }

    public function feedbackCheck(Request $request)
    {
        $this->validate(
            $request,
            [
                'studentId' => 'required|integer'
            ]
        );

        $currentSemester = $this->studentFetchSemesterLists($request->studentId);
        $markStatus = $this->studentFetchCourseAndTeacherInfoBySemester($request->studentId, $currentSemester['current_semester']);


        if ($markStatus['is_mark_exists'] == true) {
            $teacherServiceFeedback = TeacherServiceFeedback::whereStudentId($request->studentId)->whereSemester($currentSemester['current_semester'])->first();

            if (!$teacherServiceFeedback) {
                return response()->json(['status' => false, 'message' => 'Please fill up teachers service feedback form first then you will get the others menu.'], 403);
            }

            return response()->json(['status' => true, 'message' => 'teacher feedback'], 200);
        } elseif ($markStatus['is_mark_exists'] == false) {
            return response()->json(['status' => true, 'message' => 'semester mark is not update yet'], 200);
        }

        return response()->json(['status' => true, 'message' => 'semester not found'], 200);
    }

    public function filterList($searchKey)
    {

        $students = Student::where('NAME', 'like', '%' . $searchKey . '%')
            ->orWhere('EMAIL', 'like', '%' . $searchKey . '%')
            ->orWhere('REG_CODE', 'like', '%' . $searchKey . '%')
            ->paginate(30);
        return StudentResource::collection($students);
    }

    public function studentAdmitCard(Request $request)
    {
        $url = env('RMS_API_URL') . '/download_regular_admit_card';

        $student_id = $request->auth->ID;
        //        $student_id = '15493';

        $array = [
            'ora_uid' => $student_id,
        ];


        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/student_account_info_summary/' . $student_id . '', false, self::ssl()));

        if ($result->summary->total_current_due > 501) {
            return response()->json(['error' => 'Please clear current due amount'], 401);
        }

        $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

        $data = "";
        if ($response->status == 200) {
            $data = $response->content;
        } else {
            return response()->json(['error' => $response->content['error']], 400);
        }


        //qr code start
        $name = $data['name'];
        $semester = $data['semester'];
        $reg_code = $data['reg_code'];
        $collection = collect($data['allocated_course']);
        $sub_code = $collection->implode('code', ', ');
        $details = ("Name: " . $name . "\n" . "Reg. Code: " . $reg_code . "\n" . "Semester: " . $semester . "\n" . 'Subject Code: ' . $sub_code . "\n" . "Admit Card of Dhaka International University");
        $data['details'] = $details;
        //qr code end

        $student_id = $data['id'];
        $token = md5($student_id);

        $file_path = storage_path('admit_cards/student_portal/regular_admit_card_' . $student_id . '.pdf');
        // if($student_id == '19946')
        // {
        //     $view = view('admit_cards/regular_admit_card_for_student_portal_test', $data);
        // }else{
            $view = view('admit_cards/regular_admit_card_for_student_portal', $data);
        // }
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->SetTitle('regular_admit_card_' . $token . '');
        $mpdf->WriteHTML(file_get_contents(storage_path('assets/regular_admit_card_for_student_portal.css')), 1);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view, 2);
        $mpdf->Output($file_path, 'F');
        return $mpdf->Output('regular_admit_card' . $token . '', 'I');
    }

    public function updatePhone(Request $request, $id)
    {
        $this->validate($request, [

            'phone' => ['required', 'numeric', 'digits:11'],

        ]);

        $number = $request->get("phone");
        $phone = substr($number, -11);

        $full_number = '+88' . $phone;
        $otp = rand(1111, 9999);
        $student = Student::where('id', $id)->first();

        $this->validate($request,[
            'email' => 'unique:std.users,email,'.$student->id
        ]);

        if($student) {
            $student->update([
                'otp' => $otp
            ]);
        }

        $message = "Your Phone Number Update  OTP is {$otp}";
        $this->send_sms($phone, $message);
    }

    public function updatePhoneSave(Request $request)
    {
        $id = $request->user_id;
        $field_name = $request->field;
        $update_phone = $request->update_phone;
        $otp = $request->otp;

        $data = Student::find($id);
        if ($data->otp == $otp) {
            Student::where('id', $id)->update([
                $field_name => $update_phone,
                'otp' => null
            ]);
        } else {
            return response(['error' => 'Please Enter correct otp number'], 400);
        }
    }
    public function updateEmail(Request $request, $id)
    {
        $this->validate($request, [

            'email' => ['required', 'email'],

        ]);
        $email = $request->get("email");
        DB::connection('std')->table("student")->where('id', $id)->update([
            'EMAIL' => trim($email)
        ]);
    }


    public function bloodShow(Request $request)
    {
        $donor = Student::where('ID', $request->auth->ID);
        if ($donor->exists()) {
            $donate_info = $donor->first();
            if ($donate_info) {
                $last_donate_day = Carbon::now()->diffInDays(Carbon::parse($donate_info->last_donate));
                if ((int)$last_donate_day >= 120) {
                    $donate_status = true;
                } else {
                    $donate_status = false;
                }
            }
        }
        $student = Student::where('blood_status', 1)
            //->withCount('relStudentBlood')
            ->where('id', "!=", $request->auth->ID)
            ->where(function ($query) {
                $query->where("last_donate", "<=", Carbon::now()->subDays(120)->toDateTimeString())
                    ->orWhere('last_donate', Null);
            })
            ->when($request->input('b_group'), function ($query) use ($request) {
                return $query->where('blood_group', $request->input("b_group"));
            })
            ->whereIn('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])
            ->select("NAME", "PHONE_NO", "EMAIL", "BLOOD_GROUP", "CAMPUS_ID", "last_donate", "ID", "DEPARTMENT_ID", "BATCH_ID", "ROLL_NO")
            ->with("relDepartment", "relBatch", 'relStudentBlood')
            ->orderByDesc('last_donate')
            ->paginate(30);
        return response()->json(['donor_status' => $donate_status, 'donor' => $student,'donor_blood_status'=>$donor->first()->blood_status]);
    }
    public function bloodCreate(Request $request)
    {
        $date = date('m/d/Y');
        $this->validate($request, [
            'wantToDonate' => ['required', 'boolean'],
            'last_donate' => ['boolean', 'nullable'],
            'donate_date' => ['nullable', 'date', "before_or_equal:$date", 'required_if:last_donate,true'],
        ], ['donate_date.required_if' => 'please fill donate date']);

        try {
            $student = Student::where('id', $request->auth->ID);
            if ($request->wantToDonate) {
                $student->update([
                    "blood_status" => 1
                ]);

                if ($student->exists()) {
                    $donate_info = $student->first();
                    if ($donate_info) {
                        $last_donate_day = Carbon::now()->diffInDays(Carbon::parse($donate_info->last_donate));
                        if ((int)$last_donate_day <= 120) {
                            return response(['donor_status' => ["You Can not Donate Before 3 month. Your Last Donate Was $last_donate_day day's Ago."],'donor_blood_status'=>$student->first()->blood_status], 422);
                        }
                    }
                }
                if ($request->donateNow) {
                    $student->update([
                        "last_donate" => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    BloodDonate::create([
                        "students_id" => $request->auth->ID,
                        "last_donate" => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                if ($request->last_donate) {
                    $student->update([
                        "last_donate" => Carbon::parse($request->donate_date)->format('Y-m-d H:i:s')
                    ]);

                    BloodDonate::create([
                        "students_id" => $request->auth->ID,
                        "last_donate" => Carbon::parse($request->donate_date)->format('Y-m-d H:i:s')
                    ]);
                }
            } else {
                $student->update([
                    "blood_status" => 0
                ]);
            }
            return response(["msg"=>"success",'donor_blood_status'=>$student->first()->blood_status]);
        } catch (\Exception $e) {
            // return response("something wrong", 500);
            return response($e->getMessage(), 500);
        }
    }
    public function updatePersonalInfo(Request $request, $id, $type)
    {
        if ($type == 'personal-info') {
            $this->validate(
                $request,
                [
                    'name' => ['required', 'string', 'max:40'],
                    'slug_name' => ['required', 'string', 'max:40', 'unique:std.student,slug_name,' . $id],
                    'gender' => ['required', 'in:M,F'],
                    'blood_group' => ['required', 'in:O+,O-,A+,A-,B+,B-,AB+,AB-'],
                    'dob' => ['required', 'date_format:Y-m-d'],
                    'birth_place' => ['required', 'string', 'max:100'],
                    'parmanent_address' => ['required', 'string', 'max:200'],
                    'mailing_address' => ['required', 'string', 'max:200'],
                    'nationality' => ['required', 'string', 'max:30'],
                    'marital_status' => ['required', 'in:Married,Single,Widowed,Divorced'],
                    'birth_or_nid_no' => ['nullable', 'string', 'max:50'],
                ]
            );

            try {
                DB::transaction(function () use ($request, $id) {
                    $slug = str_replace([".", " ", "(", ")", "-", "@"], [""], strtolower($request->slug_name));
                    $student = Student::where('id', $id)->update([
                        'NAME' => $request->name,
                        'slug_name' => $slug,
                        'GENDER' => $request->gender,
                        'BLOOD_GROUP' => $request->blood_group,
                        'DOB' => $request->dob,
                        'BIRTH_PLACE' => $request->birth_place,
                        'PARMANENT_ADD' => $request->parmanent_address,
                        'MAILING_ADD' => $request->mailing_address,
                        'NATIONALITY' => $request->nationality,
                        'MARITAL_STATUS' => $request->marital_status,
                        'STD_BIRTH_OR_NID_NO' => $request->birth_or_nid_no,

                        'about_me' => $request->about_me,
                    ]);
                });

                return response()->json(['success' => 'Update Successfull.'], 201);
            } catch (\Exception $e) {

                return response()->json(['error' => 'Update Failed.'], 400);
            }
        }

        if ($type == 'parent-info') {
            $this->validate($request, [
                'father_name' => ['required', 'string', 'max:30'],
                'father_occupation' => ['required', 'string', 'max:30'],
                'father_nid_no' => ['nullable', 'string', 'max:50'],
                'mother_name' => ['required', 'string', 'max:30'],
                'mother_occupation' => ['required', 'string', 'max:30'],
                'mother_nid_no' => ['nullable', 'string', 'max:50'],
            ]);
            try {
                $student = Student::where('id', $id)->update([
                    'F_NAME' => $request->father_name,
                    'F_OCCU' => $request->father_occupation,
                    'FATHER_NID_NO' => $request->father_nid_no,
                    'M_NAME' => $request->mother_name,
                    'M_OCCU' => $request->mother_occupation,
                    'MOTHER_NID_NO' => $request->mother_nid_no,

                ]);

                return response()->json(['success' => 'Update Successfull.'], 201);
            } catch (\Exception $e) {

                return response()->json(['error' => 'Update Failed.'], 400);
            }
        }
        if ($type == 'guardian-info') {
            $this->validate($request, [
                'guardian_name' => ['required', 'string', 'max:30'],
                'guardian_occupation' => ['required', 'string', 'max:30'],
                'emergency_name' => ['required', 'string', 'max:30'],
                'emergency_occupation' => ['required', 'string', 'max:30'],
                'emergency_address' => ['required', 'string', 'max:200'],
                'emergency_relation' => ['required', 'string', 'max:20'],
            ]);
            try {
                $student = Student::where('id', $id)->update([
                    'G_NAME' => $request->guardian_name,
                    'G_OCCU' => $request->guardian_occupation,
                    'E_NAME' => $request->emergency_name,
                    'E_OCCU' => $request->emergency_occupation,
                    'E_ADDRESS' => $request->emergency_address,
                    'E_RELATION' => $request->emergency_relation,

                ]);


                return response()->json(['success' => 'Update Successfull.'], 201);
            } catch (\Exception $e) {

                return response()->json(['error' => 'Update Failed.'], 400);
            }
        }
    }
}
