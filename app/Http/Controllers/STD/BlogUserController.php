<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Resources\BlogUserResource;
use App\Models\STD\Student;

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
            	'password' => 'bail|required|min:6',
                'confirmed_password' => 'bail|min:6|required_with:password|same:password'
            ],
            [
                'password.min'=>'password minimum length 6'
            ]
        );


        $currentUser = Student::find($request->auth->id);

        
        $currentUser = Student::where('id', $student_id)->first();
        if ( empty($currentUser->diu_email) ) {
            return response()->json(['error' => 'You need DIU email account to create Bolg account.'], 400);
        }


        $realInputFields = $request->post();

        $usernameOrEmail = $currentUser->diu_email;
        $nameOrDisplayName = $currentUser->name;

        $realInputFields['username'] = $usernameOrEmail;
        $realInputFields['email'] = $usernameOrEmail;
        $realInputFields['name'] = $nameOrDisplayName;
        $realInputFields['display_name'] = $nameOrDisplayName;

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
