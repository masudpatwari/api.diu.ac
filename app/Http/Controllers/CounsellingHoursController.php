<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CounsellingHours;
use App\Http\Resources\CounsellingHoursResource;

class CounsellingHoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $counselling = CounsellingHours::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($counselling))
        {
            return CounsellingHoursResource::collection($counselling);
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
                'day' => 'required',
                'time_from' => 'required',
                'time_to' => 'required',
                'place' => 'required',
            ]
        );

        $counselling_array = [
            'employee_id' => $request->auth->id,
            'day' => $request->input('day'),
            'time_from' => $request->input('time_from'),
            'time_to' => $request->input('time_to'),
            'place' => $request->input('place'),
        ];

        $counselling = CounsellingHours::create($counselling_array);

        if(!empty($counselling->id))
        {
            return response()->json($counselling, 201);
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
        $counselling = CounsellingHours::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($counselling))
        {
            return new CounsellingHoursResource($counselling);
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
                'day' => 'required',
                'time_from' => 'required',
                'time_to' => 'required',
                'place' => 'required',
            ]
        );

        $replicate = CounsellingHours::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $counselling = $replicate->replicate();
        $counselling->push();
        $counselling->delete();
        
        $counselling_array = [
            'employee_id' => $request->auth->id,
            'day' => $request->input('day'),
            'time_from' => $request->input('time_from'),
            'time_to' => $request->input('time_to'),
            'place' => $request->input('place'),
        ];

        $counselling = CounsellingHours::where(['employee_id' => $request->auth->id, 'id' => $id])->update($counselling_array);

        if(!empty($counselling))
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
        $counselling = CounsellingHours::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($counselling)) {
            if ($counselling->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
