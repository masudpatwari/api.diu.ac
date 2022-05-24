<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AwardScholarships;
use App\Http\Resources\AwardScholarshipsResource;

class AwardScholarshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $award = AwardScholarships::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($award))
        {
            return AwardScholarshipsResource::collection($award);
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
                'title' => 'required|max:300',
            ],
            [
                'title.required' => 'Title is required.',
            ]
        );

        $award_array = [
            'employee_id' => $request->auth->id,
            'title' => $request->input('title'),
        ];

        $award = AwardScholarships::create($award_array);

        if(!empty($award->id))
        {
            return response()->json($award, 201);
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
        $award = AwardScholarships::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($award))
        {
            return new AwardScholarshipsResource($award);
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

        $replicate = AwardScholarships::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $award = $replicate->replicate();
        $award->push();
        $award->delete();

        $award_array = [
            'title' => $request->input('title'),
        ];

        $award = AwardScholarships::where(['employee_id' => $request->auth->id, 'id' => $id])->update($award_array);

        if(!empty($award))
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
        $award = AwardScholarships::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($award)) {
            if ($award->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
