<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialContact;
use App\Http\Resources\SocialContactsResource;
use App\Rules\CheckSocialNameExists;

class SocialContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $social = SocialContact::where(['employee_id' => $request->auth->id])->orderBy('id', 'asc')->get();
        if (!empty($social))
        {
            return SocialContactsResource::collection($social);
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
                'social_names' => ['required', new CheckSocialNameExists,'max:100'],
                'url' => 'required',
            ]
        );

        $social_array = [
            'employee_id' => $request->auth->id,
            'name' => $request->input('social_names'),
            'url' => $request->input('url'),
        ];

        $social = SocialContact::create($social_array);

        if(!empty($social->id))
        {
            return response()->json($social, 201);
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
        $social = SocialContact::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($social))
        {
            return new SocialContactsResource($social);
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
                'social_names' => ['required', new CheckSocialNameExists],
                'url' => 'required',
            ]
        );

        $replicate = SocialContact::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        $social = $replicate->replicate();
        $social->push();
        $social->delete();

        $social_array = [
            'name' => $request->input('social_names'),
            'url' => $request->input('url'),
        ];

        $social = SocialContact::where(['employee_id' => $request->auth->id, 'id' => $id])->update($social_array);

        if(!empty($social))
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
        $social = SocialContact::where(['employee_id' => $request->auth->id, 'id' => $id])->first();
        if (!empty($social)) {
            if ($social->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
