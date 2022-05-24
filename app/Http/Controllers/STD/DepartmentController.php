<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\Department;
use App\Http\Resources\StudentDepartmentResource;
use App\Http\Resources\StudentGroupResource;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = Department::all();
        if (!empty($departments)) {
            return StudentDepartmentResource::collection($departments);
        }
        return response()->json(['error' => 'Empty'], 400);
    }
    
    public function student_group()
    {
        $students = Department::with(['relStudent' => function( $query){
            $query->orderBy('id', 'desc');
        }])->get();
        if (!empty($students))
        {
            return StudentGroupResource::collection($students);
        }
        return response()->json(NULL, 404);
    }

    public function show(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
