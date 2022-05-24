<?php

namespace App\Http\Controllers;

use App\Employee;
use App\smsResetPasswordToken;
use Illuminate\Http\Request;
use App\Rules\CheckValidPhoneNumber;
use App\Rules\CheckStrongPassword;
use App\Http\Resources\EmployeeShortDetailsResource;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\RMS\WpEmpRms;

class ForgetPasswordResetController extends BaseController
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function send_verification_code(Request $request)
    {
        $this->validate($this->request, [
            'phone_no' => ['required', new CheckValidPhoneNumber],
        ]);
        $phone_no = $this->request->input('phone_no');
        $token_str = str_random(8);

        $employee = Employee::where('personal_phone_no', $phone_no)->first();
        if ($employee) {
            smsResetPasswordToken::wherePhoneNumber($phone_no)->delete();
            $token = smsResetPasswordToken::create([
                'employee_id' => $employee->id,
                'phone_number' => $employee->personal_phone_no,
                'token' => $token_str,
                'ip' => $request->ip(),
            ]);
            $message = "Your verification code is ".$token_str."";
            try{

                if( smsSender( $phone_no, $message ) ){
                    return response()->json(NULL, 200);
                }
                else {
                    return response()->json(['error' => 'SMS send fail. Please, contact with IT Team DIU.'], 400);
                }
            }catch ( Exception $e){
               return response()->json(['error' => $e], 400); 
            }
        }
        return response()->json(['error' => 'Personal Phone No does not exist.'], 404);
    }

    public function verification_code(Request $request)
    {
        $this->validate($this->request, [
            'phone_no' => ['required', new CheckValidPhoneNumber],
            'verification_code' => 'required',
        ]);

        $phone_number = $request->input('phone_no');
        $verification_code = $request->input('verification_code');

        $verification_code = smsResetPasswordToken::where(['token' => $verification_code, 'phone_number' => $phone_number])->first();
        if (!empty($verification_code)) {
            return response()->json(NULL, 200);
        }
        return response()->json(['error' => 'Invalid verification code.'], 404);
    }

    public function password_reset(Request $request)
    {
        $this->validate($request,
            [
                'phone_no' => ['required', new CheckValidPhoneNumber],
                'verification_code' => 'required',
                'password' => ['required', new CheckStrongPassword,'confirmed'],
                'password_confirmation' => 'required',
            ]
        );

        $phone_number = $request->input('phone_no');
        $verification_code = $request->input('verification_code');
        $password_confirmation = md5($request->input('password_confirmation'));

        $employee_id = smsResetPasswordToken::where(['token' => $verification_code, 'phone_number' => $phone_number])->first()->employee_id;
        $password = Employee::where(['id' => $employee_id])->update([
            'password' => $password_confirmation,
        ]);

        if (!empty($password)) {
            /*
            *   RMS password cange
            */
            $message = "CMS Password  ";

            $changed = WpEmpRms::changePassword(Employee::find($employee_id)->office_email, $password_confirmation);
            if($changed){
                $message .= "Also RMS password ";
            }

            return response()->json(['success' => $message . ' changed'], 201);
        }
        return response()->json(['error' => 'Password change Failed.'], 400);
    }
}
