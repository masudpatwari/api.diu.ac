<?php

namespace App\Http\Controllers\Admission;

use App\Employee;
use App\Models\Admission\CourseCalculationProgramFee;
use App\Program;
use App\Traits\MetronetSmsTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;


class CourseFeeCalculationController extends Controller
{
    use MetronetSmsTraits;

    public function generalStudentPrograms(Request $request)
    {

        /*$this->validate($request, [
            'type' => 'required|in:general,special',
        ]);*/

        return CourseCalculationProgramFee::active()->get();
    }

    private function generalPrograms()
    {
        $result = [
            ['id' => 1, 'name' => 'BBA (First Shift)', 'course_fee' => '330000', 'admission_fee' => '15000'],
            ['id' => 2, 'name' => 'BBA (Second Shift)', 'course_fee' => '283500', 'admission_fee' => '15000'],

            ['id' => 3, 'name' => 'English (First Shift)', 'course_fee' => '185000', 'admission_fee' => '15000'],
            ['id' => 4, 'name' => 'English (Second Shift)', 'course_fee' => '165000', 'admission_fee' => '15000'],
            ['id' => 5, 'name' => 'Sociology (First Shift)', 'course_fee' => '155000', 'admission_fee' => '15000'],
            ['id' => 6, 'name' => 'Sociology (Second Shift)', 'course_fee' => '135000', 'admission_fee' => '15000'],
            ['id' => 7, 'name' => 'CSE (First Shift)', 'course_fee' => '330000', 'admission_fee' => '20000'],
            ['id' => 8, 'name' => 'CIVIL (First Shift)', 'course_fee' => '300000', 'admission_fee' => '20000'],
            ['id' => 9, 'name' => 'EEE (First Shift)', 'course_fee' => '360000', 'admission_fee' => '20000'],
        ];
        return response()->json($result, 201);
    }

    private function specialPrograms()
    {
        $result = [
            ['id' => 1, 'name' => 'CSE (Second Shift)', 'course_fee' => '270000', 'admission_fee' => '15000'],
            ['id' => 2, 'name' => 'EEE (Second Shift)', 'course_fee' => '250000', 'admission_fee' => '15000'],
            ['id' => 3, 'name' => 'CIVIL (Second Shift)', 'course_fee' => '250000', 'admission_fee' => '15000'],
            ['id' => 4, 'name' => 'B.Pharma', 'course_fee' => '450000', 'admission_fee' => '25000'],
            ['id' => 5, 'name' => 'LLB', 'course_fee' => '550000', 'admission_fee' => '25000'],
            ['id' => 6, 'name' => 'Pol. Sci.', 'course_fee' => '155000', 'admission_fee' => '10000'],
            ['id' => 7, 'name' => 'Econom.', 'course_fee' => '155000', 'admission_fee' => '10000'],
        ];

        return response()->json($result, 201);
    }

    public function courseFeeCalculation(Request $request)
    {

        $this->validate($request, [
//            'type' => 'required|in:general,special',
            'program_id' => 'required|string',
            'ssc_result' => 'required|numeric|between:1,5|regex:/^\d*(\.\d{1,2})?$/',
            'hsc_result' => 'required|numeric|between:1,5|regex:/^\d*(\.\d{1,2})?$/',
            'sex' => 'required|in:male,female',
        ]);

        $employee = Employee::with('relDesignation', 'relDepartment')->find($request->auth->id);

        $program = CourseCalculationProgramFee::whereId($request->program_id)->active()->first();

        if (!$program) {
            return response()->json(['msg' => 'program not found'], 422);
        }

        if ($program->type == 'general') {

            $scholarshipPercentage = $this->scholarshipPercentage($request->ssc_result, $request->hsc_result, $request->sex);
            $scholarshipAmount = ($scholarshipPercentage * $program->course_fee) / 100;
            $totalCostAfterScholarship = ($program->course_fee - $scholarshipAmount) + $program->admission_fee;

            $data = [
                'program' => $program,
                'scholarshipPercentage' => $scholarshipPercentage,
                'studentSex' => $request->sex,
                'scholarshipAmount' => $scholarshipAmount,
                'totalCostAfterScholarship' => $totalCostAfterScholarship,
                'created_by' => [
                    'name' => $employee->name ?? 'N/A',
                    'phone_no' => $employee->alternative_phone_no ?? 'N/A',
                    'designation' => $employee->relDesignation->name ?? 'N/A',
                    'department' => $employee->relDepartment->name ?? 'N/A'
                ]
            ];

            return $data;
        }

        $data = [
            'program' => $program,
            'created_by' => [
                'name' => $employee->name ?? 'N/A',
                'phone_no' => $employee->alternative_phone_no ?? 'N/A',
                'designation' => $employee->relDesignation->name ?? 'N/A',
                'department' => $employee->relDepartment->name ?? 'N/A'
            ]
        ];

        return $data;

    }

    private function scholarshipPercentage($ssc_result, $hsc_result, $sex)
    {
        $totalPoint = number_format(number_format($ssc_result, 2) + number_format($hsc_result, 2), 2);

        $scholarshipPercentage = '10';

        if ( $totalPoint < 6.00) {
            $scholarshipPercentage = '10';
        }
        if ($totalPoint >= 6.00 && $totalPoint <= 6.99) {
            $scholarshipPercentage = '15';
        }
        if ($totalPoint >= 7.00 && $totalPoint <= 7.99) {
            $scholarshipPercentage = '20';
        }

        if ($totalPoint >= 8.00 && $totalPoint <= 8.99) {
            $scholarshipPercentage = '25';
        }

        if ($totalPoint >= 9.00 && $totalPoint <= 9.99) {
            $scholarshipPercentage = '30';
        }

        if ($totalPoint == '10') {
            $scholarshipPercentage = '40';
        }

        if ($sex == 'female') {
            $scholarshipPercentage = $scholarshipPercentage + '10';
        }

        return $scholarshipPercentage;
    }

    public function courseFeeCalculationAdmissionSite(Request $request)
    {

        $this->validate($request, [
            'program_id' => 'required|string',
            'ssc_result' => 'required|numeric|between:1,5|regex:/^\d*(\.\d{1,2})?$/',
            'hsc_result' => 'required|numeric|between:1,5|regex:/^\d*(\.\d{1,2})?$/',
            'sex' => 'required|in:male,female',
        ]);

        $program = CourseCalculationProgramFee::whereId($request->program_id)->active()->first();

        if (!$program) {
            return response()->json(['msg' => 'program not found'], 422);
        }

        if ($program->type == 'general') {

            $scholarshipPercentage = $this->scholarshipPercentage($request->ssc_result, $request->hsc_result, $request->sex);
            $scholarshipAmount = ($scholarshipPercentage * $program->course_fee) / 100;
            $totalCostAfterScholarship = ($program->course_fee - $scholarshipAmount) + $program->admission_fee;

            $data = [
                'studentSex' => $request->sex,
                'program' => $program,
                'scholarshipAmount' => $scholarshipAmount,
                'totalCostAfterScholarship' => $totalCostAfterScholarship,
                'perSemesterFee' => number_format(($totalCostAfterScholarship - $program->admission_fee) / $program->total_semester),
            ];

            return $data;
        }

        $data = [
            'program' => $program,
        ];

        return $data;

        return [$request->all(), $program];

    }

}
