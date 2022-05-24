<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\diuLdap;
use App\Models\STD\Student;
/**
*
*   $host='hotspot.diu.ac',$port='389', $username = 'Manager',$password = 'diu2009*'
*
*/
class StudentsLdapControllerBack extends Controller
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
        return response()->json($account_list, 200);
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
                'username' => 'required|alpha_num',
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
        $student_id = $request->auth->ID;

        $this->validate($request,
            [
                'username' => 'required|alpha_num|unique:std.student,wifi_username',
                'password' => 'bail|min:6|required',
                'confirmed_password' => 'bail|min:6|required_with:password|same:password'
            ]
        );

        $account_exists = Student::where('id', $student_id)->first();
        if (!empty($account_exists->wifi_username) && !empty($account_exists->wifi_password)) {
            return response()->json(['error' => 'Your wifi account already exists!'], 400);
        }

        $exists_username = $this->ldapObj->search_user($request->username)['count'];

        if ($exists_username == 0) {
            $this->ldapObj->addUser($request->username, $request->password);
            Student::whereId($student_id)->update([
                'wifi_username' => $request->username,
                'wifi_password' => $request->password,
            ]);
            return response()->json(['success'=>'Your wifi account created successfull!'], 201);
        }
        else
        {
            return response()->json(['error' => 'Your wifi account already exists!'], 400);
        }
        return response()->json(['error' => 'Your wifi account create failed.'], 400);
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
    public function destroy(Request $request)
    {
        $student_id = $request->auth->ID;
        $student_info = Student::where('id', $student_id)->first();
        if (empty($student_info)) {
            return response()->json(['error' => 'Your wifi account not found!'], 400);
        }

        $exists_username = $this->ldapObj->search_user($student_info->wifi_username)['count'];
        if ($exists_username == 0) {
            Student::whereId($student_id)->update([
                'wifi_username' => NULL,
                'wifi_password' => NULL,
            ]);
            return response()->json(['error' => 'Your wifi account not found!'], 400);
        }
        else
        {
            if ( $this->ldapObj->delete($student_info->wifi_username) ) {
                Student::whereId($student_id)->update([
                    'wifi_username' => NULL,
                    'wifi_password' => NULL,
                ]);
                return response()->json(['success'=>'Your wifi account is deleted!'], 201);
            }
        }
        return response()->json(['error' => 'Your wifi account delete failed.'], 400);
    }


    public function change_password(Request $request)
    {

        $this->validate($request,
            [
                'password' => 'bail|min:6|required',
                'confirmed_password' => 'bail|min:6|required_with:password|same:password'
            ]
        );

        $student_id = $request->auth->ID;
        $student_info = Student::where('id', $student_id)->first();

        if (empty($student_info)) {
            return response()->json(['error' => 'Your wifi account not found!'], 400);
        }

        $exists_username = $this->ldapObj->search_user($student_info->wifi_username)['count'];

        if ($exists_username == 0) {
            return response()->json(['error' => 'Your wifi account not found!'], 400);
        }

        if($this->ldapObj->change_password($student_info->wifi_username, $request->password)){
            $student = Student::whereId($student_id)->update([
                'wifi_password' => $request->password,
            ]);
            return response()->json(['success'=>'Your wifi account password change successfull.'], 201);
        }
        return response()->json(['error' => 'Your wifi account password Change failed!'], 400);
    }
}
