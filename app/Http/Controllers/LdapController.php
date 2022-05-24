<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Radcheck;
use Illuminate\Http\Request;
use App\classes\diuLdap;
use App\WiFi;
use Illuminate\Support\Facades\Log;

/**
 *
 *   $host='hotspot.diu.ac',$port='389', $username = 'Manager',$password = 'diu2009*'
 *
 */ 
class LdapController extends Controller
{
    public $ldapObj = null;
    public $ldap_host = null;
    public $ldap_port = null;

    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.L
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userlist = Radcheck::select('username')->get()->pluck('username');

        if ( ! $userlist ) {
            return response()->json(['error'=>'No User Found!'], 400);
        }

        $data['username'] = $userlist;

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_count()
    {
        $data['data']['number_of_user'] = Radcheck::get()->count();

        return response()->json($data,200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_username(Request $request, $user_id='')
    {
        $finalUserId = $request->auth->id;

        if ($user_id && ( isSuperAdmin() || isAdmin() ) ) {
            $finalUserId = $user_id;
        }

        $wifiInfo = wifi::where('employee_id', $finalUserId)->first();

        if ($wifiInfo) {
            $data['data']['username'] =$wifiInfo->username;
            return response()->json($data,200);
        }
        return response()->json(['error'=>'User Not Found!'],204);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check_username_existence(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required|alpha',
            ]
        );

        $exist = Radcheck::where('username', $request->username)->exists();

        if ($exist) {
            return response()->json(['error' => 'User Exists!'], 400);
        }
        return response()->json(['message' => 'User Not Exists!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $finalUserId = $request->auth->id;

        if ($request->employee_id) {
            $finalUserId = $request->employee_id;
        }
        $this->validate($request,
            [
                'username' => 'required|alpha',
                'userpassword' => 'bail|min:6|required|alpha',
                'confirmed_password' => 'bail|min:6|required_with:userpassword|same:userpassword'
            ]
        );

        $wifiAccountExsist = WiFi::where('employee_id', $finalUserId)->first();

        if ($wifiAccountExsist) {
            return response()->json(['error' => 'WiFi User Already Exists!'], 400);
        }


        $emp = Employee::find($finalUserId);

        $radExist = Radcheck::where('username', $request->username)->exists();

        if ( $radExist ){
            return response()->json(['error' => 'WiFi User Name Exist!'], 400);
        }

        Radcheck::create([
            'username' => $request->username,
            'value'=>$request->userpassword,
            'identification' => $emp->office_email ,
        ]);
//
        WiFi::insert([
            'employee_id'=> $finalUserId,
            'username'=> $request->username,
            'userpassword'=> $request->userpassword
        ]);

//            $this->ldapObj->addUser($request->username, $request->userpassword) ;

        return response()->json(['data'=>['success'=>'WiFi Account Created!']], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required|alpha',
            ]
        );
        // $this->ldapObj->search_user('naild.hossain62')

        $radExist = Radcheck::where('username', $request->username)->exists();

        if ( $radExist ){
            return response()->json(['error' => 'WiFi User Name Exist!'], 400);
        }
        return response()->json(['error' => 'WiFi User Name Not Exist!'],200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $user_id=0)
    {
        try{
            if ( $user_id && ( isAdmin() || isSuperAdmin()) ) {
                $wifiInfo = WiFi::where('employee_id', $user_id)->first();
            }else {
                $wifiInfo = WiFi::where('employee_id', $request->auth->id )->first();
            }

            if ( ! $wifiInfo) {
                return response()->json(['error' => 'User Not Found!'],400);
            }

            $wifiInfo->delete();

            $radRow = Radcheck::where('username', $request->username)->first();

            if ( $radRow ){
                $radRow->delete();
            }

            return response()->json(NULL, 204);
        }
        catch (\Exception $exception){
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
    }


    /**
     * @param Request $request
     * @param string $user_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function change_password(Request $request, $user_id='')
    {

        $this->validate($request,
            [
                'userpassword' => 'bail|min:6|required|alpha',
                'confirmed_password' => 'bail|min:6|required_with:userpassword|same:userpassword'
            ]
        );


        $finalUserId = $request->auth->id;

        if ($user_id && ( isSuperAdmin() || isAdmin() ) ) {
            $finalUserId = $user_id;
        }

        try{

            $wifiInfo = WiFi::where('employee_id', $finalUserId)->first();
            if ( ! $wifiInfo ) {
                return response()->json(['error' => 'WiFi Account User Not Found!'],400);
            }
            $wifiInfo->userpassword =$request->userpassword;
            $wifiInfo->save();


            $raddata = Radcheck::where('username', $request->username)->first();
            $raddata->value = $request->userpassword;
            $raddata->save();

            return response()->json(['success' => 'Password Changed Successfully!'],200);
        }
        catch (\Exception $exception){

            Log::error($exception->getMessage());
            return response()->json(['error' => 'Password Change Fail!'],400);
        }
    }
}
