<?php

namespace App\Http\Controllers\DiuLibrary;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiuLibrary\LibraryTeamMember;


class TeamMemberController extends Controller
{
    public function index()
    {
        return LibraryTeamMember::with('employee','employee.relDesignation','employee.relDepartment')->serialNo()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_ids' => 'required|array',
        ]);

        $data = [];
        $employee_ids = $request->employee_ids;

        foreach ($employee_ids as $employee_id) {
            $data[] = [
                'employee_id' => $employee_id
            ];
        }

        LibraryTeamMember::insert($data);
        return response()->json(['message' => 'Team Created Successfully'], 201);
    }

    public function destroy($id)
    {
        LibraryTeamMember::destroy($id);
        return response()->json(['message' => 'Team Deleted Successfully'], 200);
    }

}
