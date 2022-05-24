<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcademicQualifications;
use App\Http\Resources\AcademicQualificationsResource;

class AcademicQualificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qualifications = AcademicQualifications::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($qualifications))
        {
            return AcademicQualificationsResource::collection($qualifications);
        }
        return response()->json(NULL, 404);
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
        $this->validate($request, 
            [
                'title' => 'required',
                'year' => 'required|digits:4',
                'institute' => 'required',
            ],
            [
                'title.required' => 'Title is required.',
                'year.required' => 'Year is required.',
                'year.digits' => 'Invalid year digits.',
                'institute.required' => 'Institute name is required.',
            ]
        );

        $academic_array = [
            'employee_id' => $request->auth->id,
            'title' => $request->input('title'),
            'major' => $request->input('major'),
            'year' => $request->input('year'),
            'institute' => $request->input('institute'),
        ];

        $academic = AcademicQualifications::create($academic_array);

        if(!empty($academic->id))
        {
            return response()->json($academic, 201);
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
        $qualifications = AcademicQualifications::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($qualifications))
        {
            return new AcademicQualificationsResource($qualifications);
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
        $this->validate($request, 
            [
                'title' => 'required',
                'year' => 'required|digits:4',
                'institute' => 'required',
            ],
            [
                'title.required' => 'Title is required.',
                'year.required' => 'Year is required.',
                'year.digits' => 'Invalid year digits.',
                'institute.required' => 'Institute name is required.',
            ]
        );

        $replicate = AcademicQualifications::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $academic = $replicate->replicate();
        $academic->push();
        $academic->delete();

        $academic_array = [
            'title' => $request->input('title'),
            'major' => $request->input('major'),
            'year' => $request->input('year'),
            'institute' => $request->input('institute'),
        ];

        $academic = AcademicQualifications::where(['employee_id' => $request->auth->id, 'id' => $id])->update($academic_array);

        if(!empty($academic))
        {
            return response()->json(NULL, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $academic = AcademicQualifications::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($academic)) {
            if ($academic->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
