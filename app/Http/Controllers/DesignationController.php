<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use App\Http\Resources\DesignationResource;
use App\Http\Resources\DesignationDetailsResource;

class DesignationController extends Controller
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
        $designations = Designation::orderBy('id', 'desc')->get();
        if (!empty($designations))
        {
            return DesignationResource::collection($designations);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'type' => 'required',
                'designation_name' => 'required|max:100|unique:designations,name',
            ],
            [
                'type.required' => 'Type is required.',
                'designation_name.required' => 'Designation Name is required.',
                'designation_name.max' => 'There is a limit of 100 characters.',
                'designation_name.unique' => 'Designation Name has already exists.',
            ]
        );

        $designation_array = [
            'name' => $request->input('designation_name'),
            'type' => $request->input('type'),
            'created_by' => $request->auth->id
        ];

        $designation = Designation::create($designation_array);

        if(!empty($designation->id))
        {
            return response()->json($designation, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, 
            [
                'type' => 'required',
                'designation_name' => 'required|max:100',
            ],
            [
                'type.required' => 'Type is required.',
                'designation_name.required' => 'Designation Name is required.',
                'designation_name.max' => 'There is a limit of 100 characters.',
            ]
        );

        $designation_array = [
            'name' => $request->input('designation_name'),
            'type' => $request->input('type'),
        ];
        
        $designation = Designation::where('id', $id)->update($designation_array);
        
        if (!empty($designation)) {
            $updated_designation = Designation::find($id);
            return response()->json($updated_designation, 200);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function show($id)
    {
        $designations = Designation::find($id);
        if (!empty($designations))
        {
            return new DesignationDetailsResource($designations);
        }
        return response()->json(NULL, 404);
    }

    public function edit($id)
    {
        $designations = Designation::find($id);
        if (!empty($designations))
        {
            return new DesignationResource($designations);
        }
        return response()->json(NULL, 404);
    }
}
