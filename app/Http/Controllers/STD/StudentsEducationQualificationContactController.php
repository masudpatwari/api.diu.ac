<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\StudentEducation;

class StudentsEducationQualificationContactController extends Controller
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
                'certificate_name' => 'required|max:100',
                'institute_name' => 'required|max:100',
                'check_passing_year' => 'nullable|in:false,true',
                'passing_year' => 'nullable|required_if:check_passing_year,false|numeric|min:1990|max:'.date('Y'),
                'result' => 'required_if:check_passing_year,false',
            ]
        );

        $education_array = [
            'student_id' => $student_id,
            'certificate_name' => $request->input('certificate_name'),
            'institute_name' => $request->input('institute_name'),
            'is_still_here' => $request->input('check_passing_year'),
            'passing_year' => (!empty($request->input('passing_year')) ? $request->input('passing_year') : NULL),
            'result' => (!empty($request->input('result')) ? $request->input('result') : NULL),
        ];

        $education = StudentEducation::create($education_array);
        if(!empty($education->id))
        {
            return response()->json($education, 201);
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
        $delete = StudentEducation::where(['id' => $id, 'student_id' => $request->auth->ID])->first();
        if (!empty($delete)) {
            if ($delete->delete()) {
                return response()->json(['success' => 'Delete successfull'], 201);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
