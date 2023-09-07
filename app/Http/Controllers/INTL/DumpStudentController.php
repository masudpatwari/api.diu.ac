<?php

namespace App\Http\Controllers\INTL;

use App\Http\Controllers\Controller;
use App\Models\INTL\ForeignStudent;
use Illuminate\Http\Request;

class DumpStudentController extends Controller
{
    public function index()
    {
        try {
            return ForeignStudent::dumpStudentList();

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request)
    {
        $this->validate($request,
            [
                'student_id' => ['required', 'integer'],
                'cause' => ['required',],
            ]
        );
        try {
            ForeignStudent::makeDump($request);
            return response()->json(['message' => "Student Dumped successfully"]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    public function show($id)
    {
        //
    }

    public function makeStudentUndump(Request $request, $studentId)
    {
        $foreignStudent = ForeignStudent::where('student_id', $studentId)->where('is_dump', 1)->first();

        if (!$foreignStudent) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $foreignStudent->is_dump = 0;
        $foreignStudent->dump_date = null;
        $foreignStudent->dump_cause = null;
        $foreignStudent->dump_by = null;
        $foreignStudent->undump_by = $request->auth->id;
        $foreignStudent->save();


        return response()->json(['message' => 'Un dump successfully'], 200);
    }
}
