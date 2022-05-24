<?php

namespace App\Http\Controllers\IndLinkage;

use App\Http\Controllers\Controller;
use App\Models\Convocation\StudentConvocation;
use App\Models\IndLinkage\Company;
use App\Models\IndLinkage\Company_Employee;
use App\Models\ItSupport\SupportTicket;
use App\Models\ItSupport\SupportTicketReply;
use App\Models\STD\AttendanceData;
use App\Models\STD\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;

class CompanyEmp extends Controller
{

    protected $logoName;
    protected $coverImageName;
    protected $stampPaper;
    private $data;

    public function admin_company_list()
    {

        $company = Company::latest()->get();
        return $company;
    }

    public function admin_company_verify($company)
    {
        try {
            $company = Company::where('company_name', $company)->firstOrFail();
            if ($company->varified_time == null) {
                $company->varified_time = Carbon::now();
            } else {
                $company->varified_time = null;
            }
            $company->save();

            return response([
                "status" => "success",
                "message" => "Company Status Changed Successfully",
                "data" => $company,
                "status_code" => 200,
            ], 200);
        } catch (\Throwable $th) {
            return response([
                "status" => "error",
                "message" => $th->getMessage(),
                "status_code" => 500,
            ], 500);
        }
    }

    public function company_list()
    {
        $company = Company::select('company_name', 'description', 'logo', 'website')->whereNotNull('varified_time')->withOut('company_employee')->latest()->get();
        return $company;
    }

    public function phone_no_standarize()
    {
        return
            //        $students_phone_no = StudentConvocation::whereRaw('LENGTH(contact_no) < 14')->get();
            $students_phone_no = StudentConvocation::whereRaw('LENGTH(contact_no) = 14')->pluck('contact_no');


        $students_phone_no = StudentConvocation::whereRaw('LENGTH(contact_no) < 14')->get();





        foreach ($students_phone_no as $student) {

            // number more than expected disit



            //number having only 13 digit and +881

            if (strlen($student->contact_no) == 13) {
                $phone = (int)($student->contact_no);

                $new = substr($phone, -11);

                if (substr(81961699480, 0, 1) === "8") {
                    $student->contact_no = '+880' . substr($phone, -10);
                    $student->save();
                    //                    return [$student->contact_no, $student];
                }
            }


            //            number having only 11 digit

            //            if(strlen($student->contact_no) == 11){
            //                $phone = (int)($student->contact_no);
            //                $student->contact_no = '+88'.substr($phone, -11);
            //                $student->save();
            //            }

            //            //number having only 10 digit
            //
            //            if(strlen($student->contact_no) == 10){
            //                $phone = (int)($student->contact_no);
            //                $student->contact_no = '+880'.substr($phone, -10);
            //                $student->save();
            //            }
        }
    }

    public function test_db()
    {



        //        $url = '';
        //        $img = '';
        //
        //        try{
        //            $url = env("APP_URL") . "images/student_profile_photo_" . '17293' . ".jpg";
        //            file_get_contents($url);
        //
        //            $img = file_get_contents($url);
        //
        //        }
        //        catch (\Exception $exception){
        //            $url = env("APP_URL") . "images/no_image.jpg";
        //        }
        //
        //            return [$url, $img];
        //        file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . '17293' . ".JPG");
        ////        return
        ////        $students_phone_no = StudentConvocation::whereRaw('LENGTH(contact_no) < 14')->count();
        //        $students_phone_no = StudentConvocation::whereRaw('LENGTH(contact_no) < 14')->get();

        //        foreach ($students_phone_no as $student) {
        //            if(strlen($student->contact_no) == 11){
        //                $student->contact_no = '+88'.$student->contact_no;
        //                $student->save();
        //            }
        //        }

        //        if($students_phone_no == 0){
        //            $students = StudentConvocation::whereRaw('LENGTH(contact_no) < 14')->get();
        //            foreach ($students as $student) {
        //                $student->contact_no = '0' . $student->contact_no;
        //                $student->save();
        //            }
        //        }


        //        $students_reg_from_convocation = StudentConvocation::whereRaw('LENGTH(contact_no) < 2')->pluck('reg_code_one','id');
        //
        //
        //
        //
        //        foreach ($students_reg_from_convocation as $convocation_id => $reg_no)
        //        {
        //            $no = Student::where('REG_CODE', $reg_no)->value('PHONE_NO');
        //
        //
        //
        //            if($no)
        //            {
        //                $no = substr($no, -11);
        //
        //                $phone = '+88'.$no;
        //                StudentConvocation::where('id', $convocation_id)->update(['contact_no' => $phone]);
        //            }else{
        //                $url = (env('RMS_API_URL').'/get_student_by_reg_code/'.$reg_no);
        //
        //
        //                $response = Curl::to($url)
        //                    ->asJson(true)
        //                    ->get();
        //
        //
        //                if($response)
        //                {
        //                    $no = substr($response['mobile'], -11);
        //                    $phone = '+88'.$no;
        //
        //                    StudentConvocation::where('id', $convocation_id)->update(['contact_no' => $phone]);
        //
        //                }
        //
        //            }
        //
        //        }
        //         $all = DB::connection('test')->table('registration')->pluck('reg_no')->toArray();

        //         $reponded = DB::connection('mysql')->table('student_convocations')->pluck('reg_code_one')->toArray();

        //         foreach($reponded as $value) {
        //             if (!in_array($value, $all)) {
        //                 dump($value);
        //             }
        //         }
        //
        //         return ('ok');
    }

    /**
     * @return mixed
     */
    public function date_fix()
    {
        //    return

        try { //    DB::connection('std')->table('attendance_datas')->doesntHave('relAttendanceReport')
            // return

            // Attendance data not having student roll deleted
            // $null_attendance = AttendanceData::has('relAttendanceReport')
            $null_attendance = AttendanceData::doesntHave('relAttendanceReport')
            ->count();    
            // ->delete();
               return $null_attendance;
        } catch (\Exception $exception) {
            return $exception;
        }

        //         $all = DB::connection('test')->table('emp')->pluck('id')->toArray();

        //          $reponded = DB::connection('attendance')->table('emp')->pluck('id')->toArray();
        // //
        //         return array_diff($all, $reponded);
        // //        return ['all' => $all, 'reponded' => $reponded];
        // //         foreach($reponded as $value) {
        // //             if (!in_array($value, $all)) {
        // //                 dump($value);
        // //             }
        // //         }
    }

    public function convocation_count()
    {
        $convocation_count = StudentConvocation::where('confirmed', '1')
            ->groupBy('name_of_program_one')
            ->get(['name_of_program_one', DB::raw('count(*) as total')]);
        //            ->count();
        return $convocation_count;
    }


    public function convocation_students()
    {
        $convocation_count = StudentConvocation::get();
        return $convocation_count;
    }

    public function company_info($name)
    {
        try {
            $company = Company::where('company_name', $name)->whereNotNull('varified_time')->firstOrFail();
            return response([
                "status" => "success",
                "message" => "Company Found Successfully",
                "data" => $company,
                "status_code" => 200,
            ], 200);
        } catch (\Throwable $th) {
            return response([
                "status" => "error",
                "message" => $th->getMessage(),
                "status_code" => 500,
            ], 500);
        }
    }

    public function add_company(Request $req)
    {
        $this->data = json_decode($req->input('data'), true);
        $imageValidator = Validator::make($req->all(), [
            "company_logo" => "required|image|mimes:jpeg,png,jpg|max:2048",
            "company_cover_photo" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
            "agreement_copy" => "required|file|mimes:jpg,pdf|max:2048",
        ]);
        $validator = Validator::make($this->data, [
            'company_name' => 'bail|required|unique:indlkg.companies,company_name',
            'company_description' => 'required',
            "website" => "required|url",
            "email" => "bail|required|email",
            "country" => "required",
            "facebook" => "required|url",
            "linkedin" => "required|url",
            "phone" => "required|array",
            "phone.*" => "distinct|digits:11",
            "phone.0" => "required",
            "telephone" => "required",
            "fax" => "required",
            "street" => "required",
            "city" => "required",
            "state" => "required",
            "zip" => "required",
            "summary" => "required",
            "contact" => "array",
            "contact.*.phone" => "bail|distinct|digits:11",
            "contact.0.name" => "bail|required",
            "contact.0.phone" => "bail|required",
            "contact.1.name" => "bail|required",
            "contact.1.phone" => "bail|required",
            "contact.2.name" => "bail|required",
            "contact.2.phone" => "bail|required",
            "contact.3.name" => "bail|required",
            "contact.3.phone" => "bail|required",
            "contact.4.name" => "bail|required",
            "contact.4.phone" => "bail|required",
            "contact.5.name" => "bail|required",
            "contact.5.phone" => "bail|required",
            "contact.6.name" => "bail|required",
            "contact.6.phone" => "bail|required",
        ], [
            "contact.*.phone.digits" => "The Employee contact phone must be a filled and must be number",
            "contact.*.phone.distinct" => "The contact phone must be unique",

            "contact.0.name.required" => "Head of the company Name is required",
            "contact.0.phone.required" => "Head of the company Phone is required",

            "contact.1.name.required" => "Board of the company Name is required",
            "contact.1.phone.required" => "Board of the company Phone is required",

            "contact.2.name.required" => "Executive of the company Name is required",
            "contact.2.phone.required" => "Executive of the company Phone is required",


            "contact.3.name.required" => "Officer of the company Name is required",
            "contact.3.phone.required" => "Officer of the company Phone is required",


            "contact.4.name.required" => "MLSS of the company Name is required",
            "contact.4.phone.required" => "MLSS of the company Phone is required",

            "contact.5.name.required" => "Worker of the company Name is required",
            "contact.5.phone.required" => "Worker of the company Phone is required",


            "contact.6.name.required" => "Trainer of the company Name is required",
            "contact.6.phone.required" => "Trainer of the company Phone is required",



            "phone.required" => "Phone number must not be empty",
            "phone.*.distinct" => "Phone number must be unique",
            "phone.*.digits" => "Phone number must be digits",
            "phone.0.required" => "Must have one phone no and must be number",

            "profile_name.required" => "The Company name is required",
            "profile_name.unique" => "The Company name must be unique",
            "profile_description.required" => "The Company description is required"
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        if ($imageValidator->fails()) {
            return response()->json(['error' => $imageValidator->errors()], 422);
        }
        try {
            DB::transaction(function () use ($req) {
                $this->fileUpload($req);
                $company_id = Company::insertGetId(
                    [
                        "company_name" => $this->data["company_name"],
                        "description" => $this->data["company_description"],
                        "logo" => $this->logoName,
                        "cover_image" => $this->coverImageName,
                        "stamp_paper" =>  $this->stampPaper,
                        "summary_with_diu_hotJobs" => $this->data["summary"],
                        "website" => $this->data["website"],
                        "email" => $this->data["email"],
                        "country" => $this->data["country"],
                        "facebook_link" => $this->data["facebook"],
                        "linkedin_link" => $this->data["linkedin"],
                        "telephone" => $this->data["telephone"],
                        "phone" => json_encode($this->data["phone"]),
                        "fax" => $this->data["fax"],
                        "street" => $this->data["street"],
                        "city" => $this->data["city"],
                        "state" => $this->data["state"],
                        "zip" => $this->data["zip"],
                        "created_at" => Carbon::now()
                    ]
                );
                $this->employee_create($this->data["contact"], $company_id);
            });
            return response([
                "status" => "success",
                "message" => "Company Created Successfully",
                "status_code" => 201,
            ], 200, [
                "message" => "Company Created Successfully",
            ]);
        } catch (\Throwable $th) {
            return response([
                "status" => "error",
                "message" => $th->getMessage(),
                "status_code" => 500,
            ], 500);
        }
        return Company::all();
    }

    protected function employee_create(array $input, $company_id)
    {
        foreach ($input as $key => $value) {
            if (isset($value['name'])) {
                Company_Employee::create([
                    "company_id" => $company_id,
                    "employee_name" => $value['name'],
                    "employee_phone" => $value['phone'],
                    "employee_type" => strtoupper($value['type'])
                ]);
            }
        }
    }

    protected function fileUpload($req)
    {
        if ($req->file('company_logo')) {
            $file = $req->file('company_logo');
            $extension = $file->getClientOriginalExtension();
            $filename = date('d_m_y_h_i_s_a') . time() . '.' . $extension;
            $filepath = Storage::disk('indlnk')->putFileAs('avatar', $req->file('company_logo'), $filename);
            $this->logoName = env("APP_URL") . '/images/industrial_linkage/' . "$filepath";
        }
        if ($req->file('company_cover_photo')) {
            $file = $req->file('company_cover_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = date('d_m_y_h_i_s_a') . time() . '.' . $extension;
            $filepath = Storage::disk('indlnk')->putFileAs('company_cover_photo', $req->file('company_logo'), $filename);
            $this->coverImageName = env("APP_URL") . '/images/industrial_linkage/' . "$filepath";
        }
        if ($req->file('agreement_copy')) {
            $file = $req->file('agreement_copy');
            $extension = $file->getClientOriginalExtension();
            $filename = date('d_m_y_h_i_s_a') . time() . '.' . $extension;
            $filepath = Storage::disk('indlnk')->putFileAs('agreement_copy', $req->file('company_logo'), $filename);
            $this->stampPaper = env("APP_URL") . '/images/industrial_linkage/' . "$filepath";
        }
    }


    //    protected function ticket_auto_assign()
    //    {
    //        return 'ok';
    //        dd($employeeSupportTicket = SupportTicket::has('supportTicketReplies')
    //            ->whereStatus('active')
    //            ->get());
    //    }
}
