<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use App\Http\Resources\ProgramResource;
use App\Http\Resources\ProgramEditResource;

class ProgramController extends Controller
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
         $programs = Program::all();

        if (!empty($programs)) {
            return ProgramResource::collection($programs);
        }

        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'faculty_name' => 'required|exists:faculties,id',
                'department_name' => 'required|exists:departments,id',
                'status' => 'required|in:active,inactive',
                'type' => 'required|in:Hons,Masters',
                'program_name' => 'required',
                'shift' => 'required|in:First Shift,Second Shift,Friday/Saturday',
                'program_short_name' => 'required',
                'duration' => 'required',
                'credit' => 'required|numeric',
                'semester' => 'required|numeric',
                'tuition_fee' => 'required|numeric',
                'admission_fee' => 'required|numeric',
            ]
        );

        $program_array = [
            'faculty_id' => $request->input('faculty_name'),
            'department_id' => $request->input('department_name'),
            'name' => $request->input('program_name'),
            'status' => $request->input('status'),
            'short_name' => $request->input('program_short_name'),
            'description' => $request->input('program_description'),
            'duration' => $request->input('duration'),
            'credit' => $request->input('credit'),
            'semester' => $request->input('semester'),
            'tuition_fee' => $request->input('tuition_fee'),
            'admission_fee' => $request->input('admission_fee'),
            'total_fee' => ($request->input('tuition_fee') + $request->input('admission_fee')),
            'shift' => $request->input('shift'),
            'type' => $request->input('type'),
            'created_by' => $request->auth->id,
        ];

        $program = Program::create($program_array);
        if (!empty($program->id)) {
            return response()->json($program, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, 
            [
                'faculty_name' => 'required|exists:faculties,id',
                'department_name' => 'required|exists:departments,id',
                'type' => 'required|in:Hons,Masters',
                'status' => 'required|in:active,inactive',
                'program_name' => 'required|unique:faculties,name,'.$id,
                'shift' => 'required|in:First Shift,Second Shift,Friday/Saturday',
                'program_short_name' => 'required',
                'duration' => 'required',
                'credit' => 'required|numeric',
                'semester' => 'required|numeric',
                'tuition_fee' => 'required|numeric',
                'admission_fee' => 'required|numeric',
            ]
        );

        $program_array = [
            'faculty_id' => $request->input('faculty_name'),
            'department_id' => $request->input('department_name'),
            'name' => $request->input('program_name'),
            'status' => $request->input('status'),
            'short_name' => $request->input('program_short_name'),
            'description' => $request->input('program_description'),
            'duration' => $request->input('duration'),
            'credit' => $request->input('credit'),
            'semester' => $request->input('semester'),
            'tuition_fee' => $request->input('tuition_fee'),
            'admission_fee' => $request->input('admission_fee'),
            'total_fee' => ($request->input('tuition_fee') + $request->input('admission_fee')),
            'shift' => $request->input('shift'),
            'type' => $request->input('type'),
            'created_by' => $request->auth->id,
        ];

        $program = Program::where('id', $id)->update($program_array);
        if (!empty($program)) {
            return response()->json($program, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function show($id)
    {
        $program = Program::find($id);
        if (!empty($program)) {
            return new ProgramResource($program);
        }
        return response()->json(NULL, 404);
    }

    public function edit($id)
    {
        $program = Program::find($id);
        if (!empty($program)) {
            return new ProgramEditResource($program);
        }
        return response()->json(NULL, 404);
    }
}