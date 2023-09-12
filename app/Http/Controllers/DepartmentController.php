<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\DepartmentDetailsResource;

class DepartmentController extends Controller
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
        $departments = Department::orderBy('id', 'desc')->get();
        if (!empty($departments)) {
            return DepartmentResource::collection($departments);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'type' => 'required',
                'department_name' => 'required|max:100|unique:departments,name',
                'doc_mtg_code' => 'required_if:type,academic|unique:departments,doc_mtg_code',
            ],
            [
                'type.required' => 'Type is required.',
                'doc_mtg_code.required' => 'doc mtg code is required.',
                'department_name.required' => 'Department Name is required.',
                'department_name.max' => 'There is a limit of 100 characters.',
                'department_name.unique' => 'Department Name has already exists.',
            ]
        );

        $department_array = [
            'name' => $request->input('department_name'),
            'type' => $request->input('type'),
            'doc_mtg_code' => trim($request->input('doc_mtg_code')),
            'created_by' => $request->auth->id
        ];

        $department = Department::create($department_array);

        if (!empty($department->id)) {
            return response()->json($department, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'type' => 'required',
                'department_name' => 'required|max:100',
            ],
            [
                'type.required' => 'Type is required.',
                'department_name.required' => 'Department Name is required.',
                'department_name.max' => 'There is a limit of 100 characters.',
            ]
        );

        $department_array = [
            'name' => $request->input('department_name'),
            'type' => $request->input('type'),
        ];

        $department = Department::where('id', $id)->update($department_array);

        if (!empty($department)) {
            $updated_deparments = Department::find($id);
            return response()->json($updated_deparments, 200);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function show($id)
    {
        $departments = Department::find($id);
        if (!empty($departments)) {
            return new DepartmentDetailsResource($departments);
        }
        return response()->json(NULL, 404);
    }

    public function edit($id)
    {
        $departments = Department::find($id);
        if (!empty($departments)) {
            return new DepartmentResource($departments);
        }
        return response()->json(NULL, 404);
    }
}
