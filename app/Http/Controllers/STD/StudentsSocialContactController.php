<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\StudentSocialContact;

class StudentsSocialContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'name' => 'required|in:Facebook,Twitter,Linkedin,Instagram,Github,Gitlab,Bitbucket',
                'link' => 'required|max:500',
            ]
        );

        $name = $request->input('name');
        $social_array = [
            'student_id' => $student_id,
            'name' => $name,
            'link' => $request->input('link'),
        ];

        $check = StudentSocialContact::where(['student_id' => $student_id, 'name' => $name])->exists();
        if ($check) {
            return response()->json(['error' => ''.$name.' already exists.'], 400);
        }

        $social = StudentSocialContact::create($social_array);
        if(!empty($social->id))
        {
            return response()->json($social, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $social = StudentSocialContact::find($id);
        if (!empty($social))
        {
            return $social;
            //return new MaterialBookEditResource($book);
        }
        return response()->json(NULL, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $delete = StudentSocialContact::where(['id' => $id, 'student_id' => $request->auth->ID])->first();
        if (!empty($delete)) {
            if ($delete->delete()) {
                return response()->json(['success' => 'Delete successfull'], 200);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
