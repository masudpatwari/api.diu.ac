<?php

namespace App\Http\Middleware;

use App\Models\STD\ApiKey;
use Closure;
use Exception;
use App\Models\STD\Student;

class TokenStudentAuthMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = trim($request->get('token'));

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }




        $lastAccessTimeObj = ApiKey::where('apiKey',$token)->withTrashed()->first();

        if(!$lastAccessTimeObj) {
            return response()->json([
                'error' => 'Token not found.'
            ], 401);
        }

        if( $lastAccessTimeObj->deleted_at ) {
            return response()->json([
                'error' => 'Provided token is already expired.'
            ], 401);
        }

        $lastAccessTime = $lastAccessTimeObj->lastAccessTime ;

        $session_expired_time = (int) getSystemSettingValue('session_expired_time');

        $device = $lastAccessTimeObj->device_agent ?? '';

        if( substr($device,0,4) == 'Dart' )
        {
            $session_expired_time = 36000 * 24 * 7 * 30 * 12 * 10;
        }

        $duration = time() - $lastAccessTime;


        if( $duration  > $session_expired_time ){

            $lastAccessTimeObj->delete();

            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        }


        $explode_by = '.0.0.0.0.';
        $tokenArray = explode($explode_by, decrypt($token));
        $student_id = $tokenArray[0];
        $student_password = $tokenArray[1];
        $user = Student::find($student_id);

        if( $user->PASSWORD != $student_password){
            $lastAccessTimeObj->delete();
            return response()->json([
                'error' => 'Provided token is expired due to password change.'
            ], 400);
        }

        $request->auth = $user;

        $lastAccessTimeObj->save();


        /*
        $currurnRouteName =     $request->route()[1]['as'];

        if( ! Student::haveCurrentRouteAccessPermissions($currurnRouteName, $student_id) ){
            return response()->json([
                'error' => 'Unauthorized Access'
            ], 400);
        }
        */

        return $next($request);
    }
}
