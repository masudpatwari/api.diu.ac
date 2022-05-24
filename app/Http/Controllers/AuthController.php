<?php

namespace App\Http\Controllers;

use App\ApiKey;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Employee;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }


    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate() {
        $this->validate($this->request, [
            'office_email' => 'required|email',
            'password' => 'required'
        ]);


        $device = substr($this->request->header('User-Agent'), 0,7) ?? '';

            // Find the user by email
        $employee = Employee::where('office_email', $this->request->input('office_email'))
        ->first();

        if (!$employee) {
            return response()->json(['error' => 'Email does not exist.'], 400);
        }

        if ($employee->activestatus=='0') {
            return response()->json(['error' => 'You are Released!'], 400);
        }
        // Verify the password and generate the token

        if (md5($this->request->input('password')) == $employee->password) {


            $token_string = $employee->id . '.0.0.0.0.' . $employee->password .'.0.0.0.0.' . $employee->office_email . uniqid() . time();

            $token = encrypt($token_string);

            $presentTime = time();

            $apiKey = new ApiKey();
            $apiKey->employee_id = $employee->id;
            $apiKey->apiKey = $token;
            $apiKey->lastAccessTime = $presentTime;
            $apiKey->created_by = $employee->id;
            $apiKey->updated_by = $employee->id;
            $apiKey->device_agent = $device ?? '';
            $apiKey->save();
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['error' => 'Email or password is wrong.'], 400);
    }
}
