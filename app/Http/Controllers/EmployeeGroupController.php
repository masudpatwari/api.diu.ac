<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeGroup;
use App\Http\Resources\EmployeeGroupResource;

class EmployeeGroupController extends Controller
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
        $employee_groups = EmployeeGroup::orderBy('id', 'asc')->get();
        if (!empty($employee_groups)) {
            return EmployeeGroupResource::collection($employee_groups);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:employee_groups,name',
            ]
        );

        $group_name = str_replace(["."," ","(",")","-",","], "_", strtolower($request->name));

        $employee_group_array = [
            'name' => trim($request->name),
            'slug_name' => trim($group_name),
        ];

        $employee_group = EmployeeGroup::create($employee_group_array);
        if (!empty($employee_group->id)) {
            return response()->json($employee_group, 200);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:employee_groups,name,'.$id,
            ]
        );

        $group_name = str_replace(["."," ","(",")","-",","], "_", strtolower($request->name));

        $employee_group_array = [
            'name' => trim($request->name),
            'slug_name' => trim($group_name),
        ];

        $employee_group = EmployeeGroup::where('id', $id)->update($employee_group_array);
        
        if (!empty($employee_group)) {
            return response()->json(NULL, 200);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function edit($id)
    {
        $employee_group = EmployeeGroup::where('id', $id)->first();
        if (!empty($employee_group)) {
            return new EmployeeGroupResource($employee_group);
        }
        return response()->json(NULL, 404);
    }
}
