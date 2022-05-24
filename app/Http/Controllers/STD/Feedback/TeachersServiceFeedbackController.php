<?php

namespace App\Http\Controllers\STD\Feedback;

use App\Models\STD\TeacherServiceCategory;
use App\Models\STD\TeacherServiceFeedbackDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\TeacherServiceFeedback;
use App\Http\Resources\TeacherServiceFeedbackResource;

class TeachersServiceFeedbackController extends Controller
{
    public function index(Request $request)
    {
        return TeacherServiceFeedbackResource::collection(TeacherServiceFeedback::with('student')->whereStudentId($request->auth->ID)->get());
    }

    public function category()
    {
        return TeacherServiceCategory::whereStatus(1)->get();
    }

    public function store(Request $request)
    {
//        dump(\Log::error(print_r($request->all(), true)));

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

    }
}
