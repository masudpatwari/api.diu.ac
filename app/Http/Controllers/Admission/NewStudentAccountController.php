<?php

namespace App\Http\Controllers\Admission;

use App\Models\STD\Student;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class NewStudentAccountController extends Controller
{
    use RmsApiTraits;

    public function show($reg_code)
    {
        $student = $this->getStudentByRegCode($reg_code);

        if ($student) {

            $studentPortalStatus = false;
            $studentDiuEmailStatus = false;

            $studentCheck = Student::where('ID', $student['id'])->first();
            if ($studentCheck) {
                $studentPortalStatus = true;
                if ($studentCheck->diu_email) {
                    $studentDiuEmailStatus = true;
                }
            }

            $user_name_diu_email = $student['reg_code'];
            if ($student['email']) {
                $user_name = explode('@',$student['email']);
                $user_name_diu_email = $user_name[0];
            }

            $student['password']=$this->passwordGenerate(10);
            $student['username']= $user_name_diu_email;

            return [
                'student' => $student,
                'studentPortalStatus' => $studentPortalStatus,
                'studentDiuEmailStatus' => $studentDiuEmailStatus,
            ];
        }

        return response()->json(['error' => 'No data found'], 406);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'studentId' => 'required|integer',
            ]
        );

        $std = $this->traits_get_student_by_id($request->studentId);

        if (Student::where('EMAIL', $std->email)->first()) {
            return response()->json(['error' => 'Email already exists.Please use another email'], 406);
        }

        $student = Student::create([
            'ID' => $std->id,
            'NAME' => $std->name,
            'ROLL_NO' => $std->roll_no,
            'REG_CODE' => $std->reg_code,
            'PASSWORD' => $this->passwordGenerate(10),
            'DEPARTMENT_ID' => $std->department_id,
            'BATCH_ID' => $std->batch_id,
            'SHIFT_ID' => $std->shift_id,
            'YEAR' => $std->year,
            'REG_SL_NO' => $std->reg_sl_no,
            'GROUP_ID' => $std->group_id,
            'BLOOD_GROUP' => $std->blood_group,
            'EMAIL' => $std->email,
            'PHONE_NO' => $std->phone_no,
            'ADM_FRM_SL' => $std->adm_frm_sl,
            'RELIGION' => $std->religion_id,
            'GENDER' => $std->gender,
            'DOB' => $std->dob,
            'BIRTH_PLACE' => $std->birth_place,
            'FG_MONTHLY_INCOME' => $std->fg_monthly_income,
            'PARMANENT_ADD' => $std->parmanent_add,
            'MAILING_ADD' => $std->mailing_add,
            'F_NAME' => $std->f_name,
            'F_CELLNO' => $std->f_cellno,
            'F_OCCU' => $std->f_occu,
            'M_NAME' => $std->m_name,
            'M_CELLNO' => $std->m_cellno,
            'M_OCCU' => $std->m_occu,
            'G_NAME' => $std->g_name,
            'G_CELLNO' => $std->g_cellno,
            'G_OCCU' => $std->g_occu,
            'E_NAME' => $std->e_name,
            'E_CELLNO' => $std->e_cellno,
            'E_OCCU' => $std->e_occu,
            'E_ADDRESS' => $std->e_address,
            'E_RELATION' => $std->e_relation,
            'EMP_ID' => $std->emp_id,
            'NATIONALITY' => $std->nationality,
            'MARITAL_STATUS' => $std->marital_status,
            'ADM_DATE' => $std->adm_date,
            'CAMPUS_ID' => $std->campus_id,
            'STD_BIRTH_OR_NID_NO' => $std->std_birth_or_nid_no,
            'FATHER_NID_NO' => $std->father_nid_no,
            'MOTHER_NID_NO' => $std->mother_nid_no,
            'IS_VERIFIED' => $std->mother_nid_no,
        ]);

        return response()->json(['message' => 'Student account create successfully'], 200);

    }

    public function passwordGenerate($chars)
    {
        $data = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcefghijkmnpqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
                'studentId' => 'required|integer',
                'emailPassword' => 'required',
                'diuEmail' => 'required|email',
            ]
        );

        Student::where('ID', $request->studentId)->update([
            'diu_email' => $request->diuEmail ?? null,
            'diu_email_pass' => $request->emailPassword ?? null,
        ]);

        return response()->json(['message' => 'Student email account create successfully'], 200);

    }

    public function print($student_id)
    {

        $student = Student::where('ID',$student_id)->first();

        $view = view('download_form/accountInfo', compact('student'));

        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view);
        return $mpdf->Output('account_info', 'I');

    }

}
