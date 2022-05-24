<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faculty;
use App\Http\Resources\FacultyResource;

class FacultiesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $faculties = Faculty::orderBy('id', 'asc')->get();
        if (!empty($faculties)) {
            return FacultyResource::collection($faculties);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'faculty_name' => 'required|unique:faculties,name',
                'faculty_short_name' => 'required',
            ],
            [
                'faculty_name.required' => 'Faculty name is required.',
                'faculty_name.unique' => 'Faculty name is already exists.',
                'faculty_short_name.required' => 'Faculty short name is required.',
            ]
        );

        $faculty_array = [
            'name' => $request->input('faculty_name'),
            'short_name' => $request->input('faculty_short_name'),
            'description' => $request->input('faculty_description'),
            'created_by' => $request->auth->id,
        ];

        $faculty = Faculty::create($faculty_array);
        if (!empty($faculty->id)) {
            return response()->json($faculty, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, 
            [
                'faculty_name' => 'required|unique:faculties,name,'.$id,
                'faculty_short_name' => 'required',
            ],
            [
                'faculty_name.required' => 'Faculty name is required.',
                'faculty_name.unique' => 'Faculty name is already exists.',
                'faculty_short_name.required' => 'Faculty short name is required.',
            ]
        );

        $faculty_array = [
            'name' => $request->input('faculty_name'),
            'short_name' => $request->input('faculty_short_name'),
            'description' => $request->input('faculty_description'),
        ];

        $faculty = Faculty::where('id', $id)->update($faculty_array);
        if (!empty($faculty)) {
            return response()->json($faculty, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function edit($id)
    {
        $faculty = Faculty::find($id);
        if (!empty($faculty)) {
            return new FacultyResource($faculty);
        }
        return response()->json(NULL, 404);
    }
}