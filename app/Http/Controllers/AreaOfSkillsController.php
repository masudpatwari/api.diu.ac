<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AreaOfSkills;
use App\Http\Resources\AreaOfSkillsResource;

class AreaOfSkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $skills = AreaOfSkills::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($skills))
        {
            return AreaOfSkillsResource::collection($skills);
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
            ],
            [
                'title.required' => 'Title is required.',
            ]
        );

        $skills_array = [
            'employee_id' => $request->auth->id,
            'title' => $request->input('title'),
        ];

        $skills = AreaOfSkills::create($skills_array);

        if(!empty($skills->id))
        {
            return response()->json($skills, 201);
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
        $skills = AreaOfSkills::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($skills))
        {
            return new AreaOfSkillsResource($skills);
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
            ],
            [
                'title.required' => 'Title is required.',
            ]
        );

        $replicate = AreaOfSkills::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $skills = $replicate->replicate();
        $skills->push();
        $skills->delete();

        $skills_array = [
            'employee_id' => $request->auth->id,
            'title' => $request->input('title'),
        ];

        $skills = AreaOfSkills::where(['employee_id' => $request->auth->id, 'id' => $id])->update($skills_array);

        if(!empty($skills))
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
        $skills = AreaOfSkills::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($skills)) {
            if ($skills->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
