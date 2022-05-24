<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortPosition;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ShortPositionResource;
use App\Http\Resources\ShortPositionDetailsResource;

class ShortPositionController extends Controller
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
        $short_position = ShortPosition::orderBy('id', 'desc')->get();
        if (!empty($short_position))
        {
            return ShortPositionResource::collection($short_position);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'short_position_name' => 'required|max:100|unique:shortPositions,name',
                'description' => 'required|max:100',
            ],
            [
                'short_position_name.required' => 'Short Position Name is required.',
                'short_position_name.max' => 'There is a limit of 100 characters.',
                'short_position_name.unique' => 'Short Position Name has already exists.',
                'description.required' => 'Short Position Name is required.',
                'description.max' => 'There is a limit of 100 characters.',
            ]
        );
        $short_position_array = [
            'name' => $request->input('short_position_name'),
            'description' => $request->input('description'),
            'created_by' => $request->auth->id
        ];

        $short_position = ShortPosition::create($short_position_array);
        if (!empty($short_position->id)) {
            return response()->json($short_position, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, 
            [
                'short_position_name' => 'required|max:100',
                'description' => 'required|max:100',
            ],
            [
                'short_position_name.required' => 'Short Position Name is required.',
                'short_position_name.max' => 'There is a limit of 100 characters.',
                'description.required' => 'Short Position Name is required.',
                'description.max' => 'There is a limit of 100 characters.',
            ]
        );

        $short_position_array = [
            'name' => $request->input('short_position_name'),
            'description' => $request->input('description'),
        ];

        $short_position = ShortPosition::where('id', $id)->update($short_position_array);

        if (!empty($short_position)) {
            $short_position = ShortPosition::find($id);
            return response()->json($short_position, 200);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function show($id)
    {
        $short_position = ShortPosition::find($id);
        if (!empty($short_position))
        {
            return new ShortPositionDetailsResource($short_position);
        }
        return response()->json(NULL, 404);
    }

    public function edit($id)
    {
        $short_position = ShortPosition::find($id);
        if (!empty($short_position))
        {
            return new ShortPositionResource($short_position);
        }
        return response()->json(NULL, 404);
    }

    public function delete(Request $request, $id)
    {
        $short_position = ShortPosition::find($id);
        if (!empty($short_position)) {
            if ($short_position->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }

    public function trashed()
    {
        $short_position = ShortPosition::orderBy('deleted_at', 'asc')->onlyTrashed()->get();
        if (!empty($short_position)) {
            return ShortPositionResource::collection($short_position);
        }
        return response()->json(NULL, 404);
    }


    public function restore($id)
    {
        $short_position = ShortPosition::withTrashed()->find($id);
        if (!empty($short_position)) {
            if ($short_position->restore()) {
                return response()->json(['success' => 'Restore successful.'], 201);
            }
            return response()->json(['error' => 'Restore Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
