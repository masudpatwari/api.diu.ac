<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\diuLdap;
use App\WiFi;
/**
 *
 *   $host='hotspot.diu.ac',$port='389', $username = 'Manager',$password = 'diu2009*'
 *
 */
class _LdapController_ extends Controller
{
    public $ldapObj = null;
    public $ldap_host = null;
    public $ldap_port = null;

    public function __construct()
    {

        $this->ldap_host = env('LDAP_HOST');
        $this->ldap_port = env('LDAP_PORT');
        $this->ldap_username = env('LDAP_USER');
        $this->ldap_password = env('LDAP_PASS');

        $this->ldapObj = new diuLdap( $this->ldap_host, $this->ldap_port, $this->ldap_username, $this->ldap_password );
    }
    /**
     * Display a listing of the resource.L
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_list = [];

        $userlist = $this->ldapObj->users();

        if ($userlist['count']==0) {
            return response()->json(['error'=>'No User Found!'], 400);
        }

        foreach ($this->ldapObj->users() as $key => $value) {
            if ($key == 'count')  continue;
            isset($value['cn']['0'])? $account_list[] = $value['cn']['0']:'';
        }
        $data['username'] = $account_list;
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_count()
    {
        $data['data']['number_of_user'] = $this->ldapObj->users_count();

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

    public function check_username_existence(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required',
            ]
        );
        $searchedUser = $this->ldapObj->search_user($request->username)['count'] ;

        if ($searchedUser == 0) {
            return response()->json(['message' => 'User Not Exists!'], 200);
        }
        return response()->json(['error' => 'User Exists!'], 400);
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
                'username' => 'required',
                'userpassword' => 'bail|min:6|required',
                'confirmed_password' => 'bail|min:6|required_with:userpassword|same:userpassword'
            ]
        );

        $wifiAccountExsist = WiFi::where('employee_id', $finalUserId)->first();
        if ($wifiAccountExsist) {
            return response()->json(['error' => 'WiFi User Already Exists!'], 400);
        }

        $searchedUser = $this->ldapObj->search_user($request->username)['count'] ;

        // $employee_id = $request->auth->id;
        $employee_id = 0;

        if( $searchedUser == 0 ){

            WiFi::insert([
                'employee_id'=> $finalUserId,
                'username'=> $request->username,
                'userpassword'=> $request->userpassword
            ]);

            $this->ldapObj->addUser($request->username, $request->userpassword) ;
            return response()->json(['data'=>['success'=>'WiFi Account Created!']], 201);
        }
        else {
            return response()->json(['error' => 'User Already Exists!'], 400);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required',
            ]
        );
        // $this->ldapObj->search_user('naild.hossain62')
        $feedback = $this->ldapObj->search_user($request->username);
        if ( $feedback['count']==0 ) {
            return response()->json(['error' => 'User Not Found!'],400);
        }
        return $feedback;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $user_id=0)
    {
        if ( $user_id && ( isAdmin() || isSuperAdmin()) ) {
            $wifiInfo = WiFi::where('employee_id', $user_id)->first();
        }else {
            $wifiInfo = WiFi::where('employee_id', $request->auth->id )->first();
        }

        if ( ! $wifiInfo) {
            return response()->json(['error' => 'User Not Found!'],400);
        }

        $feedback = $this->ldapObj->search_user($wifiInfo->username);

        if ( $feedback['count']==0 ) {
            return response()->json(['error' => 'WiFi User Not Found!'],400);
        }

        // if ( $this->ldapObj->delete($user_id) ) {
        if ( $this->ldapObj->delete($wifiInfo->username) ) {
            $wifiInfo->delete();
            return response()->json(NULL, 204);
        }
        return response()->json(['error' => 'Delete Failed.'], 400);
    }


    public function change_password(Request $request, $user_id='')
    {

        $this->validate($request,
            [
                'userpassword' => 'bail|min:6|required',
                'confirmed_password' => 'bail|min:6|required_with:userpassword|same:userpassword'
            ]
        );

        $finalUserId = $request->auth->id;

        if ($user_id && ( isSuperAdmin() || isAdmin() ) ) {
            $finalUserId = $user_id;
        }

        $wifiInfo = WiFi::where('employee_id', $finalUserId)->first();
        if ( ! $wifiInfo ) {
            return response()->json(['error' => 'WiFi Account User Not Found!'],400);
        }
        $wifiInfo->userpassword =$request->userpassword;
        $wifiInfo->save();

        $feedback = $this->ldapObj->search_user($wifiInfo->username);
        if ( $feedback['count']==0 ) {
            return response()->json(['error' => 'User Not Found!'],400);
        }
        if($this->ldapObj->change_password($wifiInfo->username, $request->userpassword)){
            return response()->json(['success' => 'Password Changed Successfully!'],200);
        }
        return response()->json(['error' => 'Password Change Fail!'],400);
    }
}
