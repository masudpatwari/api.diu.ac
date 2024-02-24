<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\vestacp;
use App\Employee;
/**
*
*   $host='hotspot.diu.ac',$port='389', $username = 'Manager',$password = 'diu2009*'
*
*/
class VestacpController extends Controller
{
    public $vestacpObj = null;
    public $vestacp_host = null;
    public $vestacp_port = null;

    public function __construct()
    {

        $vestacp_host = env('VESTA_HOSTNAME');
        $vestacp_username = env('VESTA_USERNAME');
        $vestacp_password = env('VESTA_PASSWORD');
        $vestacp_returncode = env('VESTA_RETURNCODE');
        $vestacp_email_domain = env('VESTA_EMAIL_DOMAIN');

        $this->vestacpObj = new vestacp( $vestacp_host, $vestacp_username, $vestacp_password, $vestacp_returncode, $vestacp_email_domain);
    }
    /**
     * Display a listing of the resource.L
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_list = [];
        $account_list = $this->vestacpObj->list_of_mail_accounts_id();
        return response()->json($account_list, 200);
    }
    public function user_count()
    {
        $account_list = $this->vestacpObj->list_of_mail_accounts_id();
        $data['data']['number_of_user'] = count($account_list);
        return response()->json($data,200);
    }

    public function check_username_existence(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required',
            ]
        );

        $account_list = $this->vestacpObj->list_of_mail_accounts_id();

        if ( ! in_array($request->username,$account_list) ) {
            return response()->json(['message' => 'User Not Exists!'], 200);
        }
        return response()->json(['error' => 'User Exists!'], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required',
                'name' => 'required',
                'userpassword' => 'bail|min:6|required',
                'confirmed_password' => 'bail|min:6|required_with:userpassword|same:userpassword'
            ]
        );

        $account_list = $this->vestacpObj->list_of_mail_accounts_id();

        if ( in_array($request->username,$account_list) ) {
            return response()->json(['error' => 'User Exists!'], 400);
        }

        $created = $this->vestacpObj->add_account( $request->username, $request->userpassword, $request->name ) ;

        if( $created=='0' ){
            return response()->json(['data'=>['success'=>'WiFi Account Created!']], 201);
        }

        return response()->json(['error' => 'Insert Failed.'], 400);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $emailId)
    {
        if (  isAdmin() || isSuperAdmin() ) {

            $account_list = $this->vestacpObj->list_of_mail_accounts_id();

            if ( ! in_array( $emailId, $account_list ) ) {
                return response()->json(['error' => 'User Not Exists!'], 400);
            }

            if ($this->vestacpObj->delete_account($emailId) == '0') {
                return response()->json(null, 204);
            }
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

        $employeeInfo = Employee::find($finalUserId);

        if ( ! $employeeInfo ) {
            return response()->json(['error' => 'Employee Not Found!'],400);
        }

        $email = $employeeInfo->office_email;
        $emailId = explode('@',$email)[0];

        $account_list = $this->vestacpObj->list_of_mail_accounts_id();

        if ( ! in_array( $emailId, $account_list ) ) {
            return response()->json(['error' => 'Mail ID Not Found!'], 400);
        }

        if ($this->vestacpObj->change_password($emailId,$request->userpassword) == '0') {
            return response()->json(null, 204);
        }
        return response()->json(['error' => 'Password Change Fail!'],400);
    }
}
