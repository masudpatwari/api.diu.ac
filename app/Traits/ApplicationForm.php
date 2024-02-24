<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Traits\RmsApiTraits;
use NumberToWords\NumberToWords;
use Illuminate\Support\Str;


trait ApplicationForm
{
    public function scholarshipForm(int $student_id)
    {

        $student = $this->traits_get_student_by_id($student_id);
        $student_account_info_summary = $this->student_account_info_summary($student_id);
        $student_account_info = $this->student_account_info($student_id);

        if ($student_account_info == false) {
            return response()->json('ERP data error', 400);
        }

        $student_account_info_collection = collect($student_account_info);
        $last_payment = $student_account_info_collection->sortByDesc('id')->first();

        $view = view('download_form/scholarship', compact('student', 'student_account_info_summary', 'last_payment'));

        return $this->mpdf_show($view);

    }

    public function reAdmissionForm(int $student_id)
    {

        $student = $this->traits_get_student_by_id($student_id);
        $view = view('download_form/re_admission', compact('student'));
        return $this->mpdf_show($view);

    }

    public function permissionForExamForm(int $student_id, $payment_amount, $payment_date, $exam_date)
    {

        $student = $this->traits_get_student_by_id($student_id);
        $student_account_info_summary = $this->student_account_info_summary($student_id);
        $student_account_info = $this->student_account_info($student_id);

        if ($student_account_info == false) {
            return response()->json('ERP data error', 400);
        }

        $student_account_info_collection = collect($student_account_info);
        $last_payment = $student_account_info_collection->sortByDesc('id')->first();

        $view = view('download_form/permission_for_exam', compact('student', 'student_account_info_summary', 'student_account_info', 'last_payment', 'payment_amount', 'payment_date', 'exam_date'));
        return $this->mpdf_show($view);

    }

    public function midTermRetakeForm(int $student_id, $course)
    {

        $course_as_array = [];
        foreach ($course as $value) {
            $course_as_array[] = json_decode($value, true);
        }

         $student = json_encode($this->traits_get_student_by_id($student_id));
        $view = view('download_form/mid_term_retake', compact('course_as_array', 'student'));

        return $this->mpdf_show($view);

    }

    public function provisionalCertificateForm(int $student_id)
    {

        $student = json_encode($this->traits_get_student_by_id($student_id));
        $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($student_id);
        if ($student_provisional_transcript_marksheet_info == false) {
            return response()->json('ERP data error', 400);
        }

        $view = view('download_form/provisional_certificate', compact('student', 'student_provisional_transcript_marksheet_info'));

        return $this->mpdf_show($view);

    }

    public function transcriptMarkCertificateForm(int $student_id)
    {
        $student = json_encode($this->traits_get_student_by_id($student_id));
        $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($student_id);

        /*if ($student_provisional_transcript_marksheet_info == false) {
            return response()->json('ERP data error', 400);
        }*/

        $view = view('download_form/transcript_mark_certificate', compact('student', 'student_provisional_transcript_marksheet_info'));

        return $this->mpdf_show($view);

    }

    public function convocationForm(int $student_id, $program, $major_in, $roll_no, $registration_no, $batch, $student_session, $group, $duration_of_the_course, $shift, $passing_year, $result, $result_published_date,$second_degree)
    {
        $student = json_encode($this->traits_get_student_by_id($student_id));
        $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($student_id);

        /*if ($student_provisional_transcript_marksheet_info == false) {
            return response()->json('ERP data error', 400);
        }*/

        $view = view('download_form/convocation', compact('student', 'student_provisional_transcript_marksheet_info', 'program', 'major_in', 'roll_no', 'registration_no','batch','student_session','group','duration_of_the_course','shift','passing_year','result','result_published_date','second_degree'));

        return $this->mpdf_show($view);

    }

    public function applicationForm(int $student_id, $certificate_type)
    {
        $student = json_encode($this->traits_get_student_by_id($student_id));
        $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($student_id);
        $student_account_info_summary = $this->student_account_info_summary($student_id);

        /*if ($student_provisional_transcript_marksheet_info == false) {
            return response()->json('ERP data error', 400);
        }*/

        $view = view('download_form/application_form', compact('student', 'student_provisional_transcript_marksheet_info', 'certificate_type', 'student_account_info_summary'));

        return $this->mpdf_show($view);

    }

    public function professionalShortCourseForm(int $student_id)
    {
        $student = $this->traits_get_student_by_id($student_id);
        $view = view('download_form/professional_short_course', compact('student'));
        return $this->mpdf_show($view);
    }

    public function researchInternshipProjectThesisForm(int $student_id, $title, $organization, $supervisor, $co_supervisor, $address, $interest_field)
    {
        $student = $this->traits_get_student_by_id($student_id);
        $student_account_info_summary = $this->student_account_info_summary($student_id);

        $view = view('download_form/research_internship_project_thesis', compact('student', 'student_account_info_summary', 'title', 'organization', 'supervisor', 'co_supervisor', 'address', 'interest_field'));
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->WriteHTML($view);
        return $mpdf->Output('application_form', 'I');
    }

    public function mpdf_show($view)
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view);
        return $mpdf->Output('scholarship_form', 'I');
    }

    public function bankSlipForm(int $student_id, $all_fees_as_array, $bank_name, $branch_name)
    {
        $student = $this->traits_get_student_by_id($student_id);
        try {
            \DB::begintransaction();

            /*$digits = 7;
            $receipt_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);*/

            $last_bank_slip = \App\Models\STD\BankSlip::dsc()->first();
            $receipt_number = str_pad($last_bank_slip->id + 1, 7, '0', STR_PAD_LEFT);

            $bank_slip = new \App\Models\STD\BankSlip();
            $bank_slip->student_id = $student_id;

            $bank_slip->receipt_number = $receipt_number;

            $bank_slip->student_name = $student->name;
            $bank_slip->reg_code = $student->reg_code;
            $bank_slip->save();


            $data = [];
            foreach ($all_fees_as_array as $row) {
                $data[] = [
                    'bank_slip_id' => $bank_slip->id,
                    'fee_type' => $row['fee_type'],
                    'fee_amount' => $row['fee_amount']
                ];
            }
            \App\Models\STD\BankSlipDetail::insert($data);


            $view = view('download_form/bank_slip', compact('student', 'all_fees_as_array', 'bank_name', 'branch_name', 'receipt_number'));
            $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'Legal', 'orientation' => 'L']);
            $mpdf->WriteHTML($view);
            return $mpdf->Output('bank_slip', 'I');

            \DB::commit();

        } catch (\Exception $e) {

            \DB::rollBack();

            return response()->json(['message' => 'Something went wrong.Please try again!.',
            ], 400);

        }
    }
}