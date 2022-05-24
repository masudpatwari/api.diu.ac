<?php

namespace App\Http\Controllers\CMS\Application;

use App\Models\Cms\OtherStudentForm;
use App\Models\Cms\OtherStudentFormStatus;
use App\Traits\RmsApiTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ApplicationController extends Controller
{
    use RmsApiTraits;

    public function show($formNo)
    {
        $otherStudentForm = OtherStudentForm::with(
            'employee:id,name',
            'otherStudentFormResearch',
            'otherStudentFormConvocationSecondDegree',
            'bankSlip',
            'otherStudentFormReceivedStatus',
            'otherStudentFormReceivedStatus.employee:id,name',
            'otherStudentFormPreparedStatus',
            'otherStudentFormPreparedStatus.employee:id,name',
            'otherStudentFormComparedStatus',
            'otherStudentFormComparedStatus.employee:id,name',
            'otherStudentFormVerifiedStatus',
            'otherStudentFormVerifiedStatus.employee:id,name',
            'otherStudentFormSeenStatus',
            'otherStudentFormSeenStatus.employee:id,name',
            'otherStudentFormApprovedStatus',
            'otherStudentFormApprovedStatus.employee:id,name'
        )->find($formNo);


        if (!$otherStudentForm) {
            return response()->json(['message' => 'No data found'], 404);
        }

        $otherStudentForm['bank_info'] = $this->bankInfo($otherStudentForm->bank_id);
        $otherStudentForm['purpose_info'] = $this->purposeInfo($otherStudentForm->purpose_id);

        return $otherStudentForm;

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:received,prepared,compared,verified,seen,approved',
            'verify_status' => 'required|in:1,2',
        ]);

        $otherStudentForm = OtherStudentForm::find($id);

        if (!$otherStudentForm) {
            return response()->json(['message' => 'no data found'], 404);
        }

        $statusMessage = 'pass';

        if ($request->verify_status == 2) {
            $statusMessage = 'approved';
        }

        OtherStudentFormStatus::create([
            'other_student_form_id' => $id,
            'employee_id' => $request->auth->id,
            'verified_status' => $request->verify_status,
            'type' => trim($request->status),
        ]);


        return response()->json(['message' => $request->status . ' ' . $statusMessage . ' ' . 'successfully'], 201);
    }


}
