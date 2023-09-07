<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\alumni\AccessToken;
use App\Models\alumni\Alumni;
//use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AlumniAuthController extends Controller
{
    public function login(Request $request)
    {

        Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ])->validate();


       $user = Alumni::where('user_name', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 401);
        }
        $token = $user->createToken("$user->user_name" . date('d-m-y_h:i:sa'));
        $user = Alumni::where('user_name', $request->username)->select('name', 'user_name','reg_code','job_seeker','avatar')->first();
        $response = [
            'message' => 'Welcome Sir.',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function user(Request $request )
    {
        return $request->user;
    }

    public function logout(Request $request){
        $logout=AccessToken::deleteToken($request->user->token);
        if(!$logout){
            return response([
                'message' => ['Something went wrong']
            ], 401);
        };
        $response = [
            'message' => 'Logout Successfully',
        ];

        return response($response, 200);
    }
}
