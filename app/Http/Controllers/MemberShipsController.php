<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MemberShips;
use App\Http\Resources\MemberShipsResource;

class MemberShipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $membership = MemberShips::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($membership))
        {
            return MemberShipsResource::collection($membership);
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

        $membership_array = [
            'employee_id' => $request->auth->id,
            'title' => $request->input('title'),
        ];

        $membership = MemberShips::create($membership_array);

        if(!empty($membership->id))
        {
            return response()->json($membership, 201);
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
        $membership = MemberShips::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($membership))
        {
            return new MemberShipsResource($membership);
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

        $replicate = MemberShips::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $membership = $replicate->replicate();
        $membership->push();
        $membership->delete();

        $membership_array = [
            'title' => $request->input('title'),
        ];

        $membership = MemberShips::where(['employee_id' => $request->auth->id, 'id' => $id])->update($membership_array);

        if(!empty($membership))
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
        $membership = MemberShips::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($membership)) {
            if ($membership->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
