<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentPendingIdCardController extends Controller
{
    use RmsApiTraits;


    public function index()
    {

        $studentPendingIdCard = $this->studentPendingIdCard();

        if (!$studentPendingIdCard) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $studentPendingIdCard;
        
    }


    public function update(Request $request)
    {

        $this->validate($request, [
            'student_id' => 'required|integer',
            'receiver_id' => 'required|integer',
        ]);

        $data = $request->all();
        unset($data['token']);

        $student = $this->studentPendingIdCardUpdate($data);

        if (!$student) {
            return response()->json(['error' => 'Student pending id card update fail'], 404);
        }

        return response()->json(['message' => 'Student pending id card update successfully'], 200);
    }

}

