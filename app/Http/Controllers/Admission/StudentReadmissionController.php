<?php

namespace App\Http\Controllers\Admission;

use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentReadmissionController extends Controller
{
    use RmsApiTraits;

    public function store(Request $request)
    {
        $this->validate($request, [
            'student_id' => ['required', 'integer'],
            'batch_id' => ['required', 'integer'],
            'shift_id' => ['required', 'integer'],
            'group_id' => ['required', 'integer'],
            'campus_id' => ['required', 'integer'],
            'roll' => ['required', 'integer'],
        ]);

        $data = $request->all();
        unset($data['token']);
        $data['created_by_email'] = $request->auth->office_email;

        $reAdmissionStudent = $this->reAdmissionStudent($data);

        if (!$reAdmissionStudent) {
            return response()->json(['error' => 'Student readmission fail'], 406);
        }

        return response()->json(['message' => 'Student create successfully'], 200);
    }

}

