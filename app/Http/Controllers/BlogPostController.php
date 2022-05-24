<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BlogPostResource;
/**
*
*
*/
class BlogPostController extends Controller
{

    public function __construct()
    {
        $this->blog_user_api_url = env('BLOG_API_URL') . 'posts';
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

        $postsObj =   (array) json_decode($server_output) ;
        if ( isset($postsObj['code'])) {
            return response()->json(['error' => $postsObj['message']], 400);
        }
        $postCollection = collect($postsObj);
        return response()->json(['data'=>  BlogPostResource::collection($postCollection)]);
    }

}
