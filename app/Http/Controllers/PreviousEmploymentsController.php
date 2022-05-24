<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreviousEmployments;
use App\Http\Resources\PreviousEmploymentsResource;

class PreviousEmploymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employments = PreviousEmployments::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($employments))
        {
            return PreviousEmploymentsResource::collection($employments);
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
                'position' => 'required',
                'department' => 'required',
                'institute' => 'required',
                'from' => 'required|date_format:Y-m-d',
                'to' => 'date_format:Y-m-d',
            ]
        );

        $employments_array = [
            'employee_id' => $request->auth->id,
            'position' => $request->input('position'),
            'department' => $request->input('department'),
            'institute' => $request->input('institute'),
            'from' => $request->input('from'),
            'to' => (!empty($request->input('to'))) ? $request->input('to') : NULL,
        ];

        $employments = PreviousEmployments::create($employments_array);

        if(!empty($employments->id))
        {
            return response()->json($employments, 201);
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
        $employments = PreviousEmployments::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($employments))
        {
            return new PreviousEmploymentsResource($employments);
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
                'position' => 'required',
                'department' => 'required',
                'institute' => 'required',
                'from' => 'required|date_format:Y-m-d',
                'to' => 'date_format:Y-m-d',
            ]
        );

        $replicate = PreviousEmployments::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $employments = $replicate->replicate();
        $employments->push();
        $employments->delete();

        $employments_array = [
            'employee_id' => $request->auth->id,
            'position' => $request->input('position'),
            'department' => $request->input('department'),
            'institute' => $request->input('institute'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
        ];

        $employments = PreviousEmployments::where(['employee_id' => $request->auth->id, 'id' => $id])->update($employments_array);

        if(!empty($employments))
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
        $employments = PreviousEmployments::where(['employee_id' => $request->auth->id, 'id' => $id])->first();;
        if (!empty($employments)) {
            if ($employments->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
