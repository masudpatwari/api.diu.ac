<?php

namespace App\Http\Controllers\INTL;

use App\Program;
use App\Models\INTL\User;
use App\Models\INTL\Ticket;
use App\Traits\DocmtgTraits;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use App\Models\INTL\ForeignStudent;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UpcomingStudentsController extends Controller
{
    use RmsApiTraits;
    use DocmtgTraits;

    public function letter_of_admission(Request $request)
    {

        $this->validate($request, [
            'student_id' => 'required|integer',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'program_id' => 'required|integer',
            'create_doc' => 'nullable',
        ]);

        $foreignStudent = ForeignStudent::show($request->student_id);
        $program = Program::show($request->program_id);
        $batch_details = $this->traits_get_batch_details_by_batch_id($request->batch_id);

        $doc = null;
        if ($request->has('create_doc') && $request->create_doc == true) {

            $doc = $this->create_doc(
                '',
                '',
                '',
                '',
                '' . $foreignStudent->relUser->name ?? 'NA',
                $request->auth->id,
                date("Y-m-d")
            );

            $id = $doc->id;
            $code = $id . '/INF/DIU/' . date('m') . '/' . date('Y');
            $doc->doc_mtg_code = $code;
            $doc->save();

        }


        $view = view('int/upcoming_student/letter_for_admission', compact('foreignStudent', 'batch_details', 'program', 'doc'));
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view);
        return $mpdf->Output('scholarship_form', 'I');

    }

    public function immigration_latter(Request $request)
    {
        $foreignStudent = ForeignStudent::show($request->student_id);

        $doc = null;
        if ($request->has('create_doc') && $request->create_doc == true) {

            $doc = $this->create_doc(
                '',
                '',
                '',
                '',
                '' . $foreignStudent->relUser->name ?? 'NA',
                $request->auth->id,
                date("Y-m-d")
            );

            $id = $doc->id;
            $code = $id . '/INF/DIU/' . date('m') . '/' . date('Y');
            $doc->doc_mtg_code = $code;
            $doc->save();

        }

        $view = view('int/upcoming_student/immigration_latter', compact('foreignStudent', 'doc'));
        $mpdf = new \Mpdf\Mpdf(['default_font' => 'bangla', 'tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->WriteHTML($view);
        return $mpdf->Output('immigration_latter', 'I');
    }

    public function passport_receiving_slip(Request $request)
    {
        $foreignStudent = ForeignStudent::show($request->student_id);

        $doc = null;
        if ($request->has('create_doc') && $request->create_doc == true) {

            $doc = $this->create_doc(
                '',
                '',
                '',
                '',
                '' . $foreignStudent->relUser->name ?? 'NA',
                $request->auth->id,
                date("Y-m-d")
            );

            $id = $doc->id;
            $code = $id . '/INF/DIU/' . date('m') . '/' . date('Y');
            $doc->doc_mtg_code = $code;
            $doc->save();

        }

        $view = view('int/upcoming_student/passport_receiving_slip', compact('foreignStudent', 'doc'));
        $mpdf = new \Mpdf\Mpdf(['default_font' => 'bangla', 'tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->WriteHTML($view);
        return $mpdf->Output('immigration_latter', 'I');
    }

    public function upcoming_student_store(Request $request)
    {
//        dump(\log::info(print_r($request->all(),true)));

        $this->validate($request,
            [
                'name' => 'required|string',
                'interested_subject' => 'required',
                'present_nationality' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:20',
            ]
        );

        $exit_user = User::where('email', $request->email)->first();
        $exit_ticket = Ticket::where('email', $request->email)->first();

        if ($exit_user || $exit_ticket) {
            return response()->json(['error' => 'Email already exist'], 400);
        }

        try {
            \DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => date('Y-m-d h:m:s'),
                'password' => Hash::make($request->password),
                'role' => 'student',
                'type' => 'foreign',
            ]);

            $ticket = Ticket::create([
                'ticket_id' => substr(md5(time()), 0, 16),
                'name' => $request->name,
                'email' => $request->email,
                'body' => "Hello sir,\nI'm from " . $request->present_nationality . " Please give me the information about this " . $request->interested_subject . "",
                'status' => 1,
                'type' => 'client',
                'method' => 'ticket',
                'agent_id' => NULL,
            ]);

            $student = ForeignStudent::create([
                'user_id' => $user->id,
                'interested_subject' => $request->interested_subject,
                'present_nationality' => $request->present_nationality,
                'referral_id' => $request->auth->ID,
                'is_admitted' => 'false',
            ]);

            \DB::commit();
            return response()->json(['message' => 'Student Added Successfully'], 200);

        } catch (\PDOException $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage() . ', code:' . $e->getCode()], 400);
        }
    }

    public function upcoming_student_fetch($user_id)
    {
        $foreignStudent = ForeignStudent::with('relUser')->where('user_id', $user_id)->first();

        if (!$foreignStudent) {
            return response()->json(['error' => 'Data not found', 400]);
        }

        return $foreignStudent;
    }

    public function upcoming_student_update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'permanent_address' => 'required',
            'present_address' => 'required',
            'bd_mobile' => 'required',
            'dob' => 'required|date',
            'sex' => 'required',
            'marital_status' => 'required',
            'blood_group' => 'required',
            'religion' => 'required',
            'present_nationality' => 'required',
            'interested_subject' => 'required',
            'passport_no' => 'required',
            'visa_date_of_expire' => 'required|date',
            'father_name' => 'required',
            'father_mobile' => 'required',
            'mother_name' => 'required',
            'mother_mobile' => 'required',
            'emergency_name' => 'required',
            'emergency_mobile' => 'required',
            'o_name_of_exam' => 'required',
            'o_group' => 'required',
            'o_roll_no' => 'required',
            'o_year_of_passing' => 'required|numeric',
            'o_letter_grade' => 'required',
            'o_cgpa' => 'required',
            'o_board' => 'required',
            'o_link_of_certificate' => 'required',
        ]);

        try {
            \DB::beginTransaction();

            $filename = NULL;
            /*if ($request->hasFile('profile_photo')) {
                $image = $request->file('profile_photo');
                $filename = 'STD' . $id . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/', $filename);

                $content = file_get_contents(env('STD_IMG_LOC') . '' . $filename . '');
                $options = array('ftp' => array('overwrite' => true));
                $stream = stream_context_create($options);
                file_put_contents(env('ORACLE_FTP') . '' . $filename . '', $content, 0, $stream);
                file_get_contents('http://erp.diu.ac:8080/apex/f?p=100:168:::::P168_STDID:' . $id);
            }*/

            $user = User::where('id', $request->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'profile_photo' => $filename,
            ]);

            $foreignStudent = ForeignStudent::where('user_id', $request->user_id)->first();
            $foreignStudent->fill($request->except('dob', 'date_of_issue', 'date_of_expire', 'date_of_last_visit_bd', 'visa_date_of_issue', 'visa_date_of_expire', 'date_of_arrival_bd','is_admitted','media_reference_type','media_reference_detail'));


            $foreignStudent->dob = \Carbon\Carbon::parse($request->dob)->format('Y-m-d');
            $foreignStudent->date_of_issue = \Carbon\Carbon::parse($request->date_of_issue)->format('Y-m-d');
            $foreignStudent->date_of_expire = \Carbon\Carbon::parse($request->date_of_expire)->format('Y-m-d');
            $foreignStudent->date_of_last_visit_bd = \Carbon\Carbon::parse($request->date_of_last_visit_bd)->format('Y-m-d');
            $foreignStudent->visa_date_of_issue = \Carbon\Carbon::parse($request->visa_date_of_issue)->format('Y-m-d');
            $foreignStudent->visa_date_of_expire = \Carbon\Carbon::parse($request->visa_date_of_expire)->format('Y-m-d');
            $foreignStudent->date_of_arrival_bd = \Carbon\Carbon::parse($request->date_of_arrival_bd)->format('Y-m-d');


            if ($request->reference_type == 'Student Self'){
                $foreignStudent->media_reference_type = $request->media_reference_type;
                $foreignStudent->media_reference_detail = '';
            }else{
                $foreignStudent->media_reference_type = '';
                $foreignStudent->media_reference_detail = $request->media_reference_detail;
            }

            $foreignStudent->update();


            \DB::commit();
            return response()->json(['message' => 'Update Successfully'], 200);
        } catch (\PDOException $e) {
            \DB::rollBack();
            return response()->json(['error' => 'No Student Found'], error);
        }
    }
}
