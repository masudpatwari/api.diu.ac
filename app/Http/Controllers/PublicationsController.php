<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publications;
use App\Http\Resources\PublicationsResource;

class PublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $publications = Publications::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($publications))
        {
            return PublicationsResource::collection($publications);
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
                'type' => 'required|in:"Articles", "Conference Papers", "Research Paper", "Book"',
                'description' => 'required',
            ],
            [
                'type.required' => 'Type is required.',
                'type.in' => 'Type is Invalid.',
                'description.required' => 'Description is required.',
            ]
        );

        $publications_array = [
            'employee_id' => $request->auth->id,
            'type' => $request->input('type'),
            'description' => $request->input('description'),
        ];

        $publications = Publications::create($publications_array);

        if(!empty($publications->id))
        {
            return response()->json($publications, 201);
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
        $publications = Publications::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($publications))
        {
            return new PublicationsResource($publications);
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
                'type' => 'required|in:"Articles", "Conference Papers", "Research Paper", "Book"',
                'description' => 'required',
            ],
            [
                'type.required' => 'Type is required.',
                'type.in' => 'Type is Invalid.',
                'description.required' => 'Description is required.',
            ]
        );

        $replicate = Publications::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $publications = $replicate->replicate();
        $publications->push();
        $publications->delete();

        $publications_array = [
            'employee_id' => $request->auth->id,
            'type' => $request->input('type'),
            'description' => $request->input('description'),
        ];

        $publications = Publications::where(['employee_id' => $request->auth->id, 'id' => $id])->update($publications_array);

        if(!empty($publications))
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
        $publications = Publications::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($publications)) {
            if ($publications->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
