<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrainingExperiences;
use App\Http\Resources\TrainingExperiencesResource;

class TrainingExperiencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $experiences = TrainingExperiences::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($experiences))
        {
            return TrainingExperiencesResource::collection($experiences);
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
                'title' => 'required|max:100',
                'duration' => 'required',
                'year' => 'required|digits:4',
                'institute' => 'required|max:100',
            ],
            [
                'title.required' => 'Title is required.',
                'duration.required' => 'Duration is required.',
                'year.required' => 'Year is required.',
                'year.digits' => 'Invalid year digits.',
                'institute.required' => 'Institute name is required.',
            ]
        );

        $experiences_array = [
            'employee_id' => $request->auth->id,
            'title' => $request->input('title'),
            'duration' => $request->input('duration'),
            'year' => $request->input('year'),
            'institute' => $request->input('institute'),
        ];

        $experiences = TrainingExperiences::create($experiences_array);

        if(!empty($experiences->id))
        {
            return response()->json($experiences, 201);
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
        $experiences = TrainingExperiences::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($experiences))
        {
            return new TrainingExperiencesResource($experiences);
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
                'duration' => 'required',
                'year' => 'required|digits:4',
                'institute' => 'required',
            ],
            [
                'title.required' => 'Title is required.',
                'duration.required' => 'Duration is required.',
                'year.required' => 'Year is required.',
                'year.digits' => 'Invalid year digits.',
                'institute.required' => 'Institute name is required.',
            ]
        );

        $replicate = TrainingExperiences::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $experiences = $replicate->replicate();
        $experiences->push();
        $experiences->delete();

        $experiences_array = [
            'employee_id' => $request->auth->id,
            'title' => $request->input('title'),
            'duration' => $request->input('duration'),
            'year' => $request->input('year'),
            'institute' => $request->input('institute'),
        ];

        $experiences = TrainingExperiences::where(['employee_id' => $request->auth->id, 'id' => $id])->update($experiences_array);

        if(!empty($experiences))
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
        $experiences = TrainingExperiences::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($experiences)) {
            if ($experiences->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
