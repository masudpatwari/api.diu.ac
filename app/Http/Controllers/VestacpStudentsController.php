<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\vestacp;
use App\Employee;
use App\Models\STD\Student;
/**
*
*   $host='hotspot.diu.ac',$port='389', $username = 'Manager',$password = 'diu2009*'
*
*/
class VestacpStudentsController extends Controller
{
    public $vestacpObj = null;
    public $vestacp_host = null;
    public $vestacp_port = null;

    public function __construct()
    {

        $vestacp_host = env('VESTA_STD_HOSTNAME');
        $vestacp_username = env('VESTA_STD_USERNAME');
        $vestacp_password = env('VESTA_STD_PASSWORD');
        $vestacp_returncode = env('VESTA_STD_RETURNCODE');
        $vestacp_email_domain = env('VESTA_STD_EMAIL_DOMAIN');

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
                'username' => 'required|unique:std.student,diu_email',
                'password' => 'bail|min:6|required',
                'confirmed_password' => 'bail|min:6|required_with:password|same:password'
            ]
        );
        $student_id = $request->auth->ID;
        $account_list = $this->vestacpObj->list_of_mail_accounts_id();

        $account_exists = Student::where('id', $student_id)->first();
        if (!empty($account_exists->diu_email) && !empty($account_exists->diu_email_pass)) {
            return response()->json(['error' => 'Your Mail account already exists!'], 400);
        }

        if ( in_array($request->username, $account_list) ) {
            return response()->json(['error' => 'Your username already exists!'], 400);
        }

        $created = $this->vestacpObj->add_account( $request->username, $request->password, $request->name ) ;

        if( $created == '0' ){
            $student = Student::where('id', $student_id)->update([
                'diu_email' => $request->username.'@'.env('VESTA_STD_EMAIL_DOMAIN'),
                'diu_email_pass' => $request->password,
            ]);
            return response()->json(['success'=>'Your Mail account created successfull!'], 201);
        }

        return response()->json(['error' => 'Your Mail account create failed.'], 400);
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
            return response()->json(['error' => 'Your Mail account not found!'], 400);
        }

        $email = $student_info->diu_email;
        $username = explode('@', $email)[0];

        $account_list = $this->vestacpObj->list_of_mail_accounts_id();
        if ( ! in_array( $username, $account_list ) ) {
            $student = Student::whereId($student_id)->update([
                'diu_email' => NULL,
                'diu_email_pass' => NULL,
            ]);
            return response()->json(['error' => 'Your Mail account not found!'], 400);
        }

        if ($this->vestacpObj->delete_account($username) == '0') {
            $student = Student::whereId($student_id)->update([
                'diu_email' => NULL,
                'diu_email_pass' => NULL,
            ]);
            return response()->json(['success'=>'Your Mail account is deleted!'], 201);
        }
        return response()->json(['error' => 'Your Mail account delete failed.'], 400);
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
            return response()->json(['error' => 'Your Mail account not found!'], 400);
        }

        $email = $student_info->diu_email;
        $username = explode('@', $email)[0];

        $account_list = $this->vestacpObj->list_of_mail_accounts_id();
        if ( ! in_array($username, $account_list) ) {
            return response()->json(['error' => 'Your Mail account not found!'], 400);
        }

        if ($this->vestacpObj->change_password($username, $request->password) == '0') {
            $student = Student::whereId($student_id)->update([
                'diu_email_pass' => $request->password,
            ]);
            return response()->json(['success'=>'Password change successfull.'], 201);
        }
        return response()->json(['error' => 'Password Change Fail!'],400);
    }
}
