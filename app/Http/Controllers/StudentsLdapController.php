<?php

namespace App\Http\Controllers;

use App\Radcheck;
use Illuminate\Http\Request;
use App\classes\diuLdap;
use App\Models\STD\Student;
use Illuminate\Support\Facades\DB;

/**
 *
 *   $host='hotspot.diu.ac',$port='389', $username = 'Manager',$password = 'diu2009*'
 *
 */
class StudentsLdapController extends Controller
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

        if (!$userlist) {
            return response()->json(['error' => 'No User Found!'], 400);
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

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_username(Request $request, $user_id = '')
    {


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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $student_id = $request->auth->ID;

        $this->validate($request,
            [
                'username' => 'required|alpha',
                'password' => 'bail|min:6|required|alpha',
                'confirmed_password' => 'bail|min:6|required_with:password|same:password'
            ]
        );

        $account_exists = Student::where('id', $student_id)->first();

        if (!empty($account_exists->wifi_username) && !empty($account_exists->wifi_password)) {
            return response()->json(['error' => 'Your wifi account already exists!'], 400);
        }

        $radExist = Radcheck::where('username', $request->username)->exists();

        if ($radExist) {
            return response()->json(['error' => 'WiFi User Name Exist!'], 400);
        }

//        $account_exists->

        if ($account_exists->REG_CODE == '') {
            return response()->json(['error' => 'Reg. Code not found!'], 400);
        }


        DB::transaction(function () use ($request, $account_exists, $student_id) {

            Radcheck::create([
                'username' => $request->username,
                'value' => $request->password,
                'identification' => $account_exists->REG_CODE,
            ]);

            $student = Student::whereId($student_id)->first();

            $this->validate($request,[
                'email' => 'unique:std.users,email,'.$student->id
            ]);

            $student->update([
                'wifi_username' => $request->username,
                'wifi_password' => $request->password,
            ]);

        }, 5);

        return response()->json(['success' => 'Your wifi account created successfully!'], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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

        if ($radExist) {
            return response()->json(['error' => 'WiFi User Name Exist!'], 400);
        }
        return response()->json(['error' => 'WiFi User Name Not Exist!'], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $student_id = $request->auth->ID;

        $student_info = Student::where('id', $student_id)->first();

        if (!$student_info) {

            return response()->json(['error' => 'Your wifi account not found!'], 400);
        }


        DB::transaction(function () use ($student_info, $student_id) {

            $student = Student::whereId($student_id)->first();

//            $this->validate(request(),
//                [
//                    'email' => 'unique:std.users,email,'.$student->id
//                ]
//            );

            if($student) {
                DB::connection('std')->table('student')->where('ID', $student->ID)->update([
                    'wifi_username' => NULL,
                    'wifi_password' => NULL,
                ]);
            }
            $radRow = Radcheck::where('username', $student_info->wifi_username)->first();


            if ($radRow) {
                $radRow->delete();
            }

        }, 5);

        return response()->json(['success' => 'Wifi account delete successfully'], 200);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function change_password(Request $request)
    {
        $this->validate($request,
            [
                'password' => 'bail|min:6|required|alpha',
                'confirmed_password' => 'bail|min:6|required_with:password|same:password'
            ]
        );

        $student_id = $request->auth->ID;
        $student_info = Student::where('id', $student_id)->first();

        if (empty($student_info)) {
            return response()->json(['error' => 'Your wifi account not found!'], 400);
        }

        try {
            DB::transaction(function () use ($request, $student_id) {

                $raddata = Radcheck::where('username', $request->username)->first();

                if (!$raddata) {
                    throw new \Exception("Wifi User Account Not Found!");
                }

                $raddata->value = $request->password;
                $raddata->save();

                $student = Student::whereId($student_id)->first();

                $this->validate($request,
                    [
                        'email' => 'unique:std.users,email,'.$student->id
                    ]
                );

                $student->update([
                    'wifi_password' => $request->password,
                ]);
            }, 5);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);
        }


        return response()->json(['success' => 'Your wifi account password change successfully.'], 201);

    }
}
