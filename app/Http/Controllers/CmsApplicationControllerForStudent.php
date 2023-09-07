<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Traits\ApplicationForm;
use Illuminate\Support\Str;
use App\Rules\CheckValidDate;
use Illuminate\Validation\Rule;


class CmsApplicationControllerForStudent extends Controller
{
    use RmsApiTraits;
    use ApplicationForm;

    /*
        scholarshipForm called form ApplicationForm traits
     */
    public function scholarship_form(Request $request)
    {

        $this->validate($request, [
            'student_id' => 'required',
        ]);


        return $this->scholarshipForm($request->student_id);
    }

    public function re_admission_form(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
        ]);

        return $this->reAdmissionForm($request->student_id);
    }


    public function provisional_certificate_form(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
        ]);

        return $this->provisionalCertificateForm($request->student_id);

    }

    public function transcript_mark_certificate_form(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
        ]);

        return $this->transcriptMarkCertificateForm($request->student_id);

    }

    public function application_certificate_form(Request $request)
    {

        $this->validate($request, [
            'certificate_type' => 'required',
            'student_id' => 'required',
        ]);

        $certificate_type = json_encode($request->certificate_type);

        return $this->applicationForm($request->student_id, $certificate_type);


    }

    public function professional_short_course_form(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
        ]);

        return $this->professionalShortCourseForm($request->student_id);

    }

    public function permission_for_exam_form(Request $request)
    {
        $this->validate($request, [
            'payment_amount' => 'required',
            'payment_date' => ['required' ,'date', new CheckValidDate],
            'exam_date' => ['required' ,'date', new CheckValidDate],
        ]);

        $payment_amount = $request->payment_amount;
        $payment_date = $request->payment_date;
        $exam_date = $request->exam_date;

        return $this->permissionForExamForm($request->student_id, $payment_amount, $payment_date, $exam_date);

    }

    public function fetch_course_lists($student_id, $semester)
    {
        $fetch_student_course = $this->student_fetch_all_course_by_student_id_and_semester($student_id, $semester);

        if ($fetch_student_course == false) {
            return response()->json('ERP data error', 400);
        }

        return $fetch_student_course;
    }

    public function mid_term_retake_form(Request $request)
    {
        $this->validate($request, [
            'retake_subject' => 'required|array',
        ]);

        $course = $request->retake_subject;
        return $this->midTermRetakeForm($request->student_id, $course);
    }


    public function convocation_form(Request $request)
    {

        $validationArray = [
            'student_id' => 'required|integer',
        ];

        if ( $request->has('second_degree') && $request->second_degree == 'true') {

            $validationArray['program'] = 'string|max:100';
            $validationArray['major_in'] = 'nullable|string|max:40';
            $validationArray['roll_no'] = 'integer';
            $validationArray['registration_no'] = 'string|max:20';
            $validationArray['batch'] = 'string|max:10';
            $validationArray['student_session'] = '';
            $validationArray['group'] = 'nullable';
            $validationArray['duration_of_the_course'] = 'integer';
            $validationArray['shift'] = 'string|max:20';
            $validationArray['passing_year'] = 'integer|digits:4';
            $validationArray['result'] = 'nullable|numeric';
            $validationArray['result_published_date'] = ['date', new CheckValidDate];
        }

        $this->validate($request, $validationArray);

//        dd($request->all());

        $program = $request->program;
        $major_in = $request->major_in;
        $roll_no = $request->roll_no;
        $registration_no = $request->registration_no;
        $batch = $request->batch;
        $student_session = $request->student_session;
        $group = $request->group;
        $duration_of_the_course = $request->duration_of_the_course;
        $shift = $request->shift;
        $passing_year = $request->passing_year;
        $result = $request->result;
        $result_published_date = $request->result_published_date;
        $second_degree = $request->second_degree;


        return $this->convocationForm($request->student_id, $program,$major_in,$roll_no,$registration_no,$batch,$student_session,$group,$duration_of_the_course,$shift,$passing_year,$result,$result_published_date,$second_degree);
    }

    public function research_internship_project_thesis_form(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
            'title' => 'required',
            'organization' => 'required',
            'supervisor' => 'required',
            'address' => 'required',
        ]);

        $title = $request->title;
        $organization = $request->organization;
        $supervisor = $request->supervisor;
        $co_supervisor = $request->co_supervisor;
        $address = $request->address;
        $interest_field = $request->interest_field;

        return $this->researchInternshipProjectThesisForm($request->student_id, $title, $organization, $supervisor, $co_supervisor, $address, $interest_field);
    }
}
