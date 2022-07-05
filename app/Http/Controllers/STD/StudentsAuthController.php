<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\CheckStrongPassword;
use App\Models\STD\Student;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetStudentPassword;
use App\Mail\StudentEmailVerify;
use App\Models\STD\ApiKey;
use App\Traits\RmsApiTraits;


class StudentsAuthController extends Controller
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
    
    public function registration(Request $request)
    {
    	$this->validate($request, 
            [
                'email' => 'required|email|unique:std.student,email',
                'confirmed_office_email' => 'required|same:email',
                'password' => ['required', new CheckStrongPassword,'confirmed'],
                'password_confirmation' => 'required',
            ]
        );
        $id = $request->student_id;
        if (empty($id)) {
            return response()->json(['error' => 'Registration time expire.'], 400);
        }

        $expd = explode('15411XY', $id);
        $id1 = intval(str_replace('%&^#@1', '', $expd[0]));
        $id2 = intval(str_replace('452aqz', '', $expd[1]));

        if ($id1 != $id2) {
            return response()->json(['error' => 'Registration time expire.'], 400);
        }

        $std = $this->traits_get_student_by_id( $id1 );

        if(empty($std->email))
        {
            $data['email'] = $request->email;
            $data['id'] = $std->id;

            $this->studentEmailUpdate($data);
        }

        try{
            $data = [
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
                'EMAIL' => $request->email,
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
            ];

            $student = Student::create($data);

            $token = $this->generate_token( $student );

            $mail = Mail::to($request->email)->send(new StudentEmailVerify($token));
            return response()->json(['token' => $token], 201);
        }
        catch (\Exception $exception){
            /**
             * 1. integrity constraint violation: 1062 Duplicate entry '2739' for key 'PRIMARY' .
             *      CODE =  23000
            */
            Log::error("Exception class name: " . get_class($exception));
            Log::error($exception);

            if ($exception->getCode() == 23000){
                return response()->json(['error' => 'Registration fail due to Duplicate Student Found!'], 400);
            }

            if ( get_class($exception) == 'Swift_TransportException' ){
                return response()->json(['error' => 'Registration successful but Verification Mail Send Fail!'], 400);
            }

            return response()->json(['error' => 'Registration fail due to unknown reason!'], 400);

        }

    }

    public function login(Request $request)
    {
    	$this->validate($request, 
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );
        $email = $request->input('email');
        $password = $request->input('password'); 

        $exists = Student::where('email', $email)->first();
        if (!$exists)
        {
            return response()->json(['error' => 'Email does not exist.'], 400);
        }

        if ($exists->IS_VERIFIED == 0) {
            $token = $this->generate_token( $exists );
            $mail = Mail::to($email)->send(new StudentEmailVerify($token));
            return response()->json(['error' => 'Your account is not verified.'], 404);
        }

        $device = substr($request->header('User-Agent'), 0,7) ?? '';

        if ($password == $exists->PASSWORD)
        {
        	$token_string = $exists->ID . '.0.0.0.0.' . $exists->PASSWORD .'.0.0.0.0.' . $exists->EMAIL . uniqid() . time();
        	$token = encrypt($token_string);

            $presentTime = time();

            $apiKey = new ApiKey();
            $apiKey->student_id = $exists->ID;
            $apiKey->apiKey = $token;
            $apiKey->device_agent = $device ?? '';
            $apiKey->lastAccessTime = $presentTime;
            $apiKey->created_by = $exists->ID;
            $apiKey->updated_by = $exists->ID;
            $apiKey->save();
            $user = new StudentResource($exists);
            return response()->json(['token' => $token, 'user' => $user], 200);
        }
        return response()->json(['error' => 'Email or password is wrong.'], 400);
    }

    public function email_reset(Request $request)
    {
    	$this->validate($request, 
            [
                'reg_code' => 'required',
            ]
        );
        $reg_code = $request->input('reg_code');

        $exists = Student::where('reg_code', $reg_code)->first();
        if (empty($exists))
        {
            return response()->json(['error' => 'Reg code does not exist.'], 404);
        }
        return response()->json(['email' => $exists->EMAIL], 201);
    }

    public function forgot_password(Request $request)
    {
    	$this->validate($request, 
            [
                'email' => 'required|email',
            ]
        );
        $email = $request->input('email');

        $student = Student::where('email', $email)->first();
        if (empty($student))
        {
            return response()->json(['error' => 'Email does not exist.'], 401);
        }

        $token = $this->generate_token( $student );

        try{
            $mail = Mail::to($email)->send(new ResetStudentPassword($token));
            return response()->json(['success' => 'A fresh password reset link has been sent to your email address.'], 201);
        }

        catch (\Exception $exception){
            Log::error(__FILE__ .' - ' . __LINE__ . ' - ' . $exception);
            return response()->json(['error' => 'Password reset link sent fail'], 400);
        }
    }
    
    public function update_password(Request $request, $token)
    {
        $this->validate($request, 
            [
                'password' => ['required', new CheckStrongPassword,'confirmed'],
                'password_confirmation' => 'required',
            ]
        );


        $explode_token = $this->explode_token( $token );
        $update = Student::where('ID', $explode_token['id'])->first();

//return $update;
        if($update){

            $this->validate($request,
                [
                    'email' => 'unique:std.users,email,'.$update->ID
                ]
            );


            try {
                DB::connection('std')->beginTransaction();

                DB::connection('std')->table('student')->where('ID', $update->ID)->update([
                    'PASSWORD' => $request->input('password')]
                );

                DB::connection('std')->commit();

            }catch (\Exception $exception){
                DB::connection('std')->rollBack();


                return response()->json(['error' => $exception->getMessage()], 400);
            }

        }

//        dd($update);
//        dd($update);

        if (!empty($update)) {
            return response()->json(['success' => 'Password update successfull'], 201);
        }
        return response()->json(['error' => 'Password update failed'], 401);
    }

    public function verification_resend(Request $request)
    {
        $this->validate($request, 
            [
                'email' => 'required|email',
            ]
        );

        $student = Student::where('email', $request->email)->first();
        if (empty($student)) {
            return response()->json(['error' => 'Email does not exist.'], 404);
        }
        
        $token = $this->generate_token( $student );
        $mail = Mail::to($request->email)->send(new StudentEmailVerify($token));
        return response()->json(['success' => 'Resend verification link successfull'], 201);
    }

    public function verify_account( $token )
    {
        $explode_token = $this->explode_token( $token );
        $student = Student::where('ID', $explode_token['id'])->first();

        if ($student->IS_VERIFIED == 1) {
            return response()->json(['success' => 'Your account already verified'], 201);
        }
        if (!empty($student)) {
            if( $student->PASSWORD == $explode_token['password']){


//                $this->validate(request(),[
//                    'email' => 'unique:std.users,email,'.$student->id
//                ]);

                DB::connection('std')->table('student')->where('ID', $student->ID)->update([
                    'IS_VERIFIED' => 1
                ]);

                return response()->json(['success' => 'Your Account verification successfully'], 201);
            }
            return response()->json(['error' => 'Token verification Failed! Try again.'], 404);
        }
        return response()->json(['error' => 'Your account has been delete.'], 400);
    }

    private function explode_token( $token )
    {
        $explode_by = '.0.0.0.0.';
        $tokenArray = explode($explode_by, decrypt(trim($token)));

        return [
            'id' => $tokenArray[0],
            'password' => $tokenArray[1],
        ];

    }

    public function verify_token( $token )
    {
        try {

            $explode_token = $this->explode_token($token);
            $student = Student::where('ID', $explode_token['id'])->first();

            if (!empty($student)) {
                if ($student->PASSWORD == $explode_token['password']) {
                    return response()->json(['token' => $token], 201);
                }
                return response()->json(['error' => 'Token verification Failed! Try again.'], 404);
            }
            return response()->json(['error' => 'Your account has been delete.'], 400);

        }
        catch (\Exception $exception){
            return response()->json(['error'=>'invalid token'], 400);
        }
    }

    private function generate_token( $student )
    {
        $token_string = $student->ID . '.0.0.0.0.' . $student->PASSWORD .'.0.0.0.0.' . $student->EMAIL . uniqid() . time();
        return encrypt($token_string);
    }
}
