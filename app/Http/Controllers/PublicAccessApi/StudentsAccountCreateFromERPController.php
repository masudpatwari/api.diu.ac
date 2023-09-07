<?php

namespace App\Http\Controllers\PublicAccessApi;

use App\Employee;
use App\Models\STD\Student;
use App\Rules\EmailAccountExists;
use App\Rules\MacAddressValidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Transcript;
use App\Http\Resources\TranscriptVerificationResource;
use App\classes\vestacp;

class StudentsAccountCreateFromERPController extends Controller
{
    use RmsApiTraits;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $vestacp_host = env('VESTA_STD_HOSTNAME');
        $vestacp_username = env('VESTA_STD_USERNAME');
        $vestacp_password = env('VESTA_STD_PASSWORD');
        $vestacp_returncode = env('VESTA_STD_RETURNCODE');
        $vestacp_email_domain = env('VESTA_STD_EMAIL_DOMAIN');

        $this->vestacpObj = new vestacp( $vestacp_host, $vestacp_username, $vestacp_password, $vestacp_returncode, $vestacp_email_domain);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'P169_STUDENT' => 'bail|required|integer',
            'P169_DEVICE_MAC' => ['bail', 'required', New MacAddressValidate()],
            'P169_EMAIL' => 'bail|required|email',
            'P169_EMAIL_PASSWORD' => 'bail|required',
            'P169_USER_EMAIL' => 'bail|required|email',
            'P169_USER_PASSWORD' => 'bail|required',
        ],[
            'P169_STUDENT.required' => 'Student ID is required.',
            'P169_STUDENT.integer' => 'Student ID must be an integer.',
            'P169_DEVICE_MAC.required' => 'MAC is required.',
            'P169_EMAIL.required' => 'Email is required.',
            'P169_EMAIL.email' => 'Email format is required.',
            'P169_EMAIL.MacAddressValidate' => 'MAC must be valid.',
            'P169_USER_EMAIL.required' => 'Email is required.',
            'P169_USER_EMAIL.email' => 'Email format is required.',
            'P169_USER_PASSWORD.required' => 'Email Password is required.',

        ]);

        $device_mac = $request->P169_DEVICE_MAC;
        $email_password = $request->P169_EMAIL_PASSWORD;
        $email = $request->P169_EMAIL;
        $student_ora_id = $request->P169_STUDENT;
        $user_email = $request->P169_USER_EMAIL;
        $user_password = $request->P169_USER_PASSWORD;

        $employee = Employee::where(['office_email'=> $user_email, 'password'=>md5($user_password), 'activestatus'=> Employee::ACTIVE ])->first();

        if ( ! $employee) {
            return response()->json(['error'=>'Authentication Fail'], 403);
        }


        $account_list = $this->vestacpObj->list_of_mail_accounts_id();


        $email_parts = explode('@', $email);
        $students_email_id = $email_parts[0];
        $student_email_domain = $email_parts[1];

        if ( in_array( $students_email_id , $account_list) ) {
            return response()->json(['message' => 'Student\'s Email Already Exists'], 400);
        }



        if ($student_email_domain != 'students.diu.ac'){
            return response()->json(['message' => 'Student\'s Email must contain students.diu.ac after @ symbol'], 400);

        }


        try{

            $std =  $this->traits_get_student_by_id( $student_ora_id );

            if ( ! $std ) {
                throw new \Exception('No Student Found in ERP');
            }

            $student = Student::create([
                'ID' => $std->id,
                'NAME' => $std->name,
                'ROLL_NO' => $std->roll_no,
                'REG_CODE' => $std->reg_code,
                'PASSWORD' => $request->password,
                'DEPARTMENT_ID' => $std->department_id,
                'BATCH_ID' => $std->batch_id,
                'SHIFT_ID' => $std->shift_id,
                'YEAR' => $std->year,
                'REG_SL_NO' => $std->reg_sl_no,
                'GROUP_ID' => $std->group_id,
                'BLOOD_GROUP' => $std->blood_group,
                'EMAIL' => $std->email,
                'PHONE_NO' => $std->phone_no,
                'ADM_FRM_SL' => $std->adm_frm_sl,
                'RELIGION' => $std->religion_id,
                'GENDER' => $std->gender,
                'DOB' => $std->dob,
                'BIRTH_PLACE' => $std->birth_place,
                'FG_MONTHLY_INCOME' => $std->fg_monthly_income,
                'PARMANENT_ADD' => $std->parmanent_add,
                'MAILING_ADD' => $std->mailing_add,
                'F_NAME' => $std->f_name,
                'F_CELLNO' => $std->f_cellno,
                'F_OCCU' => $std->f_occu,
                'M_NAME' => $std->m_name,
                'M_CELLNO' => $std->m_cellno,
                'M_OCCU' => $std->m_occu,
                'G_NAME' => $std->g_name,
                'G_CELLNO' => $std->g_cellno,
                'G_OCCU' => $std->g_occu,
                'E_NAME' => $std->e_name,
                'E_CELLNO' => $std->e_cellno,
                'E_OCCU' => $std->e_occu,
                'E_ADDRESS' => $std->e_address,
                'E_RELATION' => $std->e_relation,
                'EMP_ID' => $std->emp_id,
                'NATIONALITY' => $std->nationality,
                'MARITAL_STATUS' => $std->marital_status,
                'ADM_DATE' => $std->adm_date,
                'CAMPUS_ID' => $std->campus_id,
                'STD_BIRTH_OR_NID_NO' => $std->std_birth_or_nid_no,
                'FATHER_NID_NO' => $std->father_nid_no,
                'MOTHER_NID_NO' => $std->mother_nid_no,
//                'DIU_EMAIL' => $email,
//                'DIU_EMAIL_PASS' => $email_password,
                'MAC_ADDRESS' => $device_mac,
            ]);

        }

        catch (\Exception $exception){

            if ( $exception->getCode() == 23000){
                return response()->json(['error'=> 'This student has account on student site :) ' ], 400);
            }
            return response()->json(['error'=>  $exception->getMessage() ], 400);
        }


        $created = $this->vestacpObj->add_account( $students_email_id, $email_password, $std->name) ;

        if( $created == '0' ){
            $student = Student::where('id', $std->id)->update([
                'diu_email' => $email,
                'diu_email_pass' => $email_password,
            ]);
            return response()->json(['success'=>'Your Mail account created successfully!'], 201);
        }


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

}
