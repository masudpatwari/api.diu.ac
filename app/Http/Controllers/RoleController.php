<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleDetailsResource;
use App\Http\Resources\RoleEditResource;
use App\Http\Resources\RoleAccessResource;

class RoleController extends Controller
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
        $roles = Role::orderBy('id', 'asc')->get();
        if (!empty($roles)) {
            return RoleResource::collection($roles);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'role_name' => 'required|unique:roles,name',
            ],
            [
                'role_name.required' => 'Role name is required.',
                'role_name.unique' => 'Role name is already exists.',
            ]
        );

        $role_name_array = [
            'name' => trim($request->input('role_name')),
            'slug' => slug($request->input('role_name')),
            'created_by' => $request->auth->id,
        ];

        $role = Role::create($role_name_array);
        if (!empty($role->id)) {
            return response()->json($role, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'role_name' => 'required|unique:roles,name,'.$id,
            ],
            [
                'role_name.required' => 'Role name is required.',
                'role_name.exists' => 'Role name is already exists.',
            ]
        );

        $replicate = Role::find($id);
        $role = $replicate->replicate();
        $role->deleted_by = $request->auth->id;
        $role->push();
        $role->delete();

        $role_array = [
            'name' => trim($request->input('role_name')),
        ];

        $role = Role::where('id', $id)->update($role_array);

        if (!empty($role)) {
            return response()->json($role, 200);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function show($id)
    {
        $role = Role::find($id);
        if (!empty($role)) {
            return new RoleDetailsResource($role);
        }
        return response()->json(NULL, 404);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        if (!empty($role)) {
            return new RoleEditResource($role);
        }
        return response()->json(NULL, 404);
    }

    public function delete(Request $request, $id)
    {
        $role = Role::find($id);
        if (!empty($role) && $role->name !== 'su') {
            if ($role->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }

    public function trashed()
    {
        $role = Role::orderBy('deleted_at', 'asc')->onlyTrashed()->get();
        if (!empty($role)) {
            return RoleResource::collection($role);
        }
        return response()->json(NULL, 404);
    }

    public function restore($id)
    {
        $role = Role::withTrashed()->find($id);
        $activeRole = Role::where('slug',$role->slug)->count();
        if ( $activeRole ) {
            return response()->json(['error' => 'Restore Failed. Already Active Role as same Slug'], 400);
        }
        if ($role->restore()) {
            return response()->json(['success' => 'Restore successful.'], 201);
        }
        return response()->json(['error' => 'Restore Failed.'], 400);
    }
}
