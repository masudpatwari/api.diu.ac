<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;


class StudentReportController extends Controller
{
    use RmsApiTraits;

    public function studentReport($reg_code)
    {
        $studentInfo = $this->studentInfoWithCompleteSemesterResultByRegCode($reg_code);

        if (!$studentInfo) {
            return response()->json(['error' => 'No data found'],406);
        }
        return $studentInfo;
    }
}
