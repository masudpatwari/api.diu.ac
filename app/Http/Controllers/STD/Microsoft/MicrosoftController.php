<?php

namespace App\Http\Controllers\STD\Microsoft;

use App\Models\STD\Student;
use App\Models\STD\TeacherServiceCategory;
use App\Models\STD\TeacherServiceFeedbackDetail;
use App\Traits\Microsoft;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\TeacherServiceFeedback;
use App\Http\Resources\TeacherServiceFeedbackResource;

class MicrosoftController extends Controller
{
    use Microsoft;

    public function store(Request $request)
    {
        $token = $this->token();

        $data = [
            'token' => $token ?? 'N/A',
        ];

        return $data;
    }

    public function update(Request $request)
    {
        /*$student = Student::find($request->auth->ID)->update([
            'diu_email' => $request->diu_email ?? null,
            'diu_email_pass' => $request->diu_email_pass ?? null,
        ]);*/

        $student = Student::where('ID', $request->auth->ID)->update([
            'diu_email' => $request->diu_email ?? null,
            'diu_email_pass' => $request->diu_email_pass ?? null,
        ]);

        return response()->json(['success' => 'Your Mail account created successfully!'], 201);
    }


    /*public function store(Request $request)
    {
        $this->validate($request, [
            'semester' => 'required|integer',
            'teacher' => 'required|array',
            'feedbacks' => 'required|array',
            'feedbacks.*.point' => 'required|integer|min:1',
        ]);

        $teacherServiceFeedback = TeacherServiceFeedback::where([
            'student_id' => $request->auth->ID,
            'semester' => $request->semester,
            'teacher_id' => $request->teacher['teacher_id']
        ])->first();

        if ($teacherServiceFeedback) {
            return response()->json(['message' => 'You have already applied for this semester and teacher'], 403);
        }

        try {

            \DB::transaction(function () use ($request) {
                $teacherServiceFeedback = new TeacherServiceFeedback();
                $teacherServiceFeedback->student_id = $request->auth->ID;
                $teacherServiceFeedback->skill_increase = $request->skillIncrease;
                $teacherServiceFeedback->other_comments = $request->otherComments;
                $teacherServiceFeedback->semester = $request->semester;
                $teacherServiceFeedback->course_id = $request->teacher['course_id'];
                $teacherServiceFeedback->course_code = $request->teacher['course_code'];
                $teacherServiceFeedback->course_name = $request->teacher['course_name'];
                $teacherServiceFeedback->teacher_id = $request->teacher['teacher_id'];
                $teacherServiceFeedback->teacher_name = $request->teacher['teacher_name'];
                $teacherServiceFeedback->teacher_position = $request->teacher['teacher_position'];
                $teacherServiceFeedback->total_category = count($request->feedbacks);
                $teacherServiceFeedback->save();

                $datas = $request->feedbacks;

                $feedbackDetails = [];
                foreach ($datas as $row) {
                    $feedbackDetails[] = [
                        'teacher_service_feedback_id' => $teacherServiceFeedback->id,
                        'teacher_service_category_id' => $row['categoryId'],
                        'point' => $row['point'],
                        'created_at' => Carbon::now(),
                    ];
                }

                TeacherServiceFeedbackDetail::insert($feedbackDetails);
            });

            return response()->json(['message' => 'Teacher Feedback Created Successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }

    }*/
}
