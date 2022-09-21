<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BlogUserResource;
use App\Employee;
/**
*
*   $host='hotspot.diu.ac',$port='389', $username = 'Manager',$password = 'diu2009*'
*
*/
class BlogUserController extends Controller
{

    public function __construct()
    {
        $this->blog_user_api_url = env('BLOG_API_URL') . 'users';
        $this->blog_admin_username = env('BLOG_ADMIN_USERNAME');
        $this->blog_admin_password = env('BLOG_ADMIN_PASSWORD');
    }
    /**
     * Display a listing of the resource.L
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$this->blog_user_api_url);
        curl_setopt($ch, CURLOPT_USERPWD,  $this->blog_admin_username. ":" . $this->blog_admin_password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        $usersObj =   (array) json_decode($server_output) ;

        if ( isset($usersObj['code'])) {
            return response()->json(['error' => $usersObj['message']], 400);
        }

        $userCollection = collect($usersObj);
        return response()->json(['data'=>  BlogUserResource::collection($userCollection)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,
            [
                // 'username' => 'required',
                'first_name' => '',
                'last_name' => '',
                // 'email' => 'bail|required|email',
                'password' => 'bail|required|min:6',
                'confirmed_password' => 'bail|min:6|required_with:password|same:password'
            ],
            [
                'password.min'=>'password minimum length 6'
            ]
        );



        $currentUser = Employee::find($request->auth->id);

        $realInputFields = $request->post();
        $usernameOrEmail = $currentUser->office_email;
        $nameOrDisplayName = $currentUser->name;
        $realInputFields['username'] = $usernameOrEmail;
        $realInputFields['email'] = $usernameOrEmail;
        $realInputFields['name'] = $currentUser->name;
        $realInputFields['display_name'] = $currentUser->name;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$this->blog_user_api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $realInputFields));
        curl_setopt($ch, CURLOPT_USERPWD,  $this->blog_admin_username. ":" . $this->blog_admin_password);
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        $responseArray = (array)  json_decode($server_output) ;


        if (isset($responseArray['id'])) {
            return response()->json(['data'=>['success'=>'Blog Account Created!']], 201);
        }
        else {
            return response()->json(['error' => $responseArray['message']], 400);
        }

        return response()->json(['error' => 'Failed.'], 400);
    }

}
