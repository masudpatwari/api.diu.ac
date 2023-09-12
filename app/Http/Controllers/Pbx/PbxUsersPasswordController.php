<?php

namespace App\Http\Controllers\Pbx;

use App\Models\PBX\User;
use App\Models\PBX\Sip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PbxUsersPasswordController extends Controller
{

    public function userIndex()
    {

        $data = [
//            'sips' => Sip::all(),
//            'users' => User::with('sip')->where('extension',216)->first(),
            'employee_users' => \App\Employee::with('pbx_extention', 'pbx_extention.sip')->select('name')->get(),
        ];
        return $data;
    }

    public function userUpdatePassword(Request $request)
    {

        $this->validate($request, [
            'userId' => 'required|integer',
            'password' => 'required|confirmed|min:8',
        ]);

        $slip = \DB::connection('pbx')->table('sip')
            ->where('id', $request->userId)
            ->where('keyword', 'secret')
            ->update(['data' => $request->password]);

        return response()->json(['message'=>'Password Update successfully',201]);
    }

}
