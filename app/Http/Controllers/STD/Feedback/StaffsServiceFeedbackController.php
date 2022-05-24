<?php

namespace App\Http\Controllers\STD\Feedback;

use App\Models\STD\StaffsServiceInfoFeedbackDetails;
use App\Models\STD\StaffsServiceInfoFeedbacks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\StaffServiceFeedback;

class StaffsServiceFeedbackController extends Controller
{
    public function index(Request $request)
    {
        return StaffServiceFeedback::with('department')->whereStudentId($request->auth->ID)->get();
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'semester' => 'required|integer',
            'employee_department_id' => 'required|integer',
            'departmentWiseEmployees' => 'required|array',
        ]);


        $staffServiceFeedback = StaffServiceFeedback::where([
            'student_id' => $request->auth->ID,
            'semester' => $request->semester,
            'employee_department_id' => $request->employee_department_id
        ])->first();

        if ($staffServiceFeedback) {
            return response()->json(['message' => 'You have already applied for this semester and department'], 405);
        }

        try {

            \DB::transaction(function () use ($request) {
                $staffServiceFeedback = new StaffServiceFeedback();
                $staffServiceFeedback->student_id = $request->auth->ID;
                $staffServiceFeedback->semester = $request->semester;
                $staffServiceFeedback->employee_department_id = $request->employee_department_id;
                $staffServiceFeedback->save();

                $employees = $request->departmentWiseEmployees;

                foreach ($employees as $key => $employee) {

                    if ($employee['select'] == 1) {
                        $staffsServiceInfoFeedbacks = new StaffsServiceInfoFeedbacks();
                        $staffsServiceInfoFeedbacks->staff_service_feedback_id = $staffServiceFeedback->id;
                        $staffsServiceInfoFeedbacks->employee_id = $employee['id'];
                        $staffsServiceInfoFeedbacks->total_category = count($employee['feedbackCategories']);
                        $staffsServiceInfoFeedbacks->save();

                        foreach ($employee['feedbackCategories'] as $row) {
                            $staffsServiceInfoFeedbackDetails = new StaffsServiceInfoFeedbackDetails();
                            $staffsServiceInfoFeedbackDetails->staffs_service_info_feedback_id = $staffsServiceInfoFeedbacks->id;
                            $staffsServiceInfoFeedbackDetails->staffs_service_category_id = $row['id'];
                            $staffsServiceInfoFeedbackDetails->point = $row['point'];
                            $staffsServiceInfoFeedbackDetails->save();
                        }
                    }
                }
            });

            return response()->json(['message' => 'Feedback created successfully'], 200);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }


        /*$this->validate($request, [
            'semester' => 'required|integer',
        ]);


        $studentServiceFeedback = StaffServiceFeedback::where([
            'student_id' => $request->auth->ID,
            'semester' => $request->semester
        ])->first();

        if ($studentServiceFeedback){
            return response()->json(['message' => 'You have already applied for this semester'], 403);
        }

        try {
            $form = $request->all();
            $form['student_id'] = $request->auth->ID;

            StaffServiceFeedback::create($form);

            return response()->json(['message' => 'University Feedback Created Successfully'], 200);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }*/

    }
}
