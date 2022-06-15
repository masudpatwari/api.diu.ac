<?php

namespace App\Http\Controllers\Admission;

use App\Models\Admission\StudentSignature;
use App\Traits\RmsApiTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AdmissionInActiveBatchController extends Controller
{
    use RmsApiTraits;

    public function index(Request $request)
    {
        $activeBatchForAdmission = $this->activeBatchForAdmission();

        if (!$activeBatchForAdmission) {

            return response()->json(['error' => 'data not found'], 406);

        }

        return $activeBatchForAdmission;
    }

    public function all(Request $request)
    {
        [$activeBatchForAdmission = $this->BatchForAdmission()];

        if (!$activeBatchForAdmission) {

            return response()->json(['error' => 'data not found'], 406);

        }

        return $activeBatchForAdmission;
    }

    public function studentsList($batch_id)
    {
        $activeBatchForAdmissionWiseStudentsList = $this->activeBatchForAdmissionWiseStudentsList($batch_id);
        return $activeBatchForAdmissionWiseStudentsList;
    }

    public function unverifiedStudentsList($batch_id)
    {
        $activeBatchForAdmissionWiseUnverifiedStudentsList = $this->activeBatchForAdmissionWiseUnverifiedStudentsList($batch_id);

        return $activeBatchForAdmissionWiseUnverifiedStudentsList;
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'group_id' => 'required|integer',
            'adm_frm_sl' => 'required|max:20',
            'admission_season' => 'required|integer',
            'student_name' => 'required|string|max:80',
            'blood_group' => 'required|max:4',
            'email' => 'required|email',
            'phone_no' => 'required|max:15',
            'religion_id' => 'required|integer',
            'gender' => 'required|max:1',
            'dob' => 'required',

            'birth_place' => 'nullable|max:30',
            'fg_monthly_income' => 'nullable|numeric',
            'nationality' => 'required|max:30',
            'std_birth_or_nid_no' => 'nullable|max:50',
            'marital_status' => 'required|max:20',
            'permanent_add' => 'required|string|max:200',
            'mailing_add' => 'required|string|max:100',
            'f_name' => 'required|string|max:80',
            'f_cellno' => 'required|string|max:15',
            'f_occu' => 'nullable|string|max:30',
            'father_nid_no' => 'required|max:50',
            'm_name' => 'required|string|max:80',
            'm_cellno' => 'nullable|max:15',
            'm_occu' => 'nullable|string|max:30',
            'mother_nid_no' => 'nullable|max:50',
            'g_name' => 'nullable|string|max:30',
            'g_cellno' => 'nullable|max:15',
            'g_occu' => 'nullable|string|max:30',
            'e_name' => 'required|string|max:30',
            'e_cellno' => 'required|max:15',
            'e_occu' => 'nullable|string|max:30',
            'e_relation' => 'nullable|string|max:20',

            'e_exam_name1' => 'required|string|max:40',
            'e_group1' => 'required|string|max:20',
            'e_roll_no_1' => 'required|max:10',
            'e_passing_year1' => 'required|max:4',
            'e_ltr_grd_tmarks1' => 'required|max:10',
            'e_div_cls_cgpa1' => 'required|max:10',
            'e_board_university1' => 'required|max:50',
            'e_exam_name2' => 'required|string|max:40',
            'e_group2' => 'required|string|max:20',
            'e_roll_no_2' => 'required|max:10',
            'e_passing_year2' => 'required|max:4',
            'e_ltr_grd_tmarks2' => 'required|max:10',
            'e_div_cls_cgpa2' => 'required|max:10',
            'e_board_university2' => 'required|max:50',

            'e_exam_name3' => 'nullable|string|max:40',
            'e_group3' => 'nullable|string|max:20',
            'e_roll_no_3' => 'nullable|max:10',
            'e_passing_year3' => 'nullable|max:4',
            'e_ltr_grd_tmarks3' => 'nullable|max:10',
            'e_div_cls_cgpa3' => 'nullable|max:10',
            'e_board_university3' => 'nullable|max:50',

            'e_exam_name4' => 'nullable|string|max:40',
            'e_group4' => 'nullable|string|max:20',
            'e_roll_no_4' => 'nullable|max:10',
            'e_passing_year4' => 'nullable|max:4',
            'e_ltr_grd_tmarks4' => 'nullable|max:10',
            'e_div_cls_cgpa4' => 'nullable|max:10',
            'e_board_university4' => 'nullable|max:50',

            'refereed_by_parent_id' => 'nullable|integer',
            'refe_by_std_type' => 'nullable|max:50',
            'ref_val' => 'nullable|max:50',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024',
            'signature' => 'required|mimes:jpeg,jpg,png|max:500',
        ]);

        try {
            $data = $request->all();
            unset($data['token']);
            $data['created_by_email'] = $request->auth->office_email;

            $student = $this->activeBatchStudentStore($data);

            if (!$student) {
                return response()->json(['error' => 'Student not create'], 404);
            }


            $files = $request->file('signature');

            if ($files) {

                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/student_signature'), $file_name);

                StudentSignature::create([
                    'student_oracle_id' => $student['id'],
                    'file_path' => env('APP_URL') . "/images/student_signature/{$file_name}",
                ]);
            }

            $image = $request->file('file');
            if ($image) {
                $file_name = "STD{$student['id']}.JPG";
                Storage::disk('ftp')->put($file_name, fopen($image, 'r+'));
            }

            return response()->json(['message' => 'Student create successfully'], 200);

        } catch (\Exception $e) {
            dump(\Log::error(print_r($e->getMessage(), true)));
            return response()->json(['error' => $e->getMessage()], 404);
        }


    }

    public function unverifiedStudentsPaymentAndRegCodeGenerate(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'receipt_no' => 'required',
            'admission_fee' => 'required',
            'bank_status' => 'required',
            'bank_id' => 'required',
            'note' => 'nullable|string|max:100',
            'student_id' => 'required|integer',
            'department_id' => 'required|integer',
            'student_type' => 'nullable',
        ]);

        $unverifiedStudentRegCodeGenerateStore = $this->receiptNoCheck($request->receipt_no);

        if ($unverifiedStudentRegCodeGenerateStore['status']) {
            return response()->json(['error' => 'Receipt no already used.(Receipt no must be unique)'], 406);
        }

        $data = $request->all();
        unset($data['name']);
        unset($data['token']);
        $data['created_by_email'] = $request->auth->office_email;
        $data['university_code'] = env('UNIVERSITY_CODE') ?? '014';
        $data['hall_code'] = env('HALL_CODE') ?? '00';
        $data['program_code'] = $this->programCode($request->department_id);

        $studentPayment = $this->unverifiedStudentRegCodeGenerateStore($data);

        if (!$studentPayment) {
            return response()->json(['error' => 'Reg code and roll generate fail.'], 404);
        }

        $data = [
            'name' => $studentPayment['name'],
            'role' => $studentPayment['roll_no'],
            'reg' => $studentPayment['reg_code'],
            'batch_name' => $studentPayment['batch_name'],
            'department_name' => $studentPayment['department_name'],
        ];

        return response()->json(['data' => $data], 200);


    }

    public function studentTransfer(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required|integer',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'group_id' => 'required|integer',
            'campus_id' => 'required|integer',
        ]);

        $data = $request->all();
        unset($data['name']);
        unset($data['token']);
        $data['created_by_email'] = $request->auth->office_email;
        $data['university_code'] = env('UNIVERSITY_CODE') ?? '014';
        $data['hall_code'] = env('HALL_CODE') ?? '00';
        $data['program_code'] = $this->programCode($request->department_id);

        $studentTransferApi = $this->studentTransferApi($data);

        if (!$studentTransferApi) {
            return response()->json(['error' => 'Student transfer fail.'], 404);
        }

        return response()->json(['message' => 'Student transfer successfully'], 200);
    }

    public function programCode($department_id)
    {
        return [
                '1' => '13533',
                '2' => '05101',
                '3' => '05101',
                '4' => '05103',
                '5' => '05151',
                '6' => '05151',
                '7' => '05081',
                '8' => '05081',
                '9' => '11091',
                '10' => '02161',
                '11' => '02161',
                '12' => '02163',
                '13' => '02163',
                '14' => '13531',
                '15' => '13531',
                '16' => '13533',
                '17' => '08131',
                '18' => '08131',
                '19' => '08132',
                '20' => '08133',
                '21' => '08133',
                '22' => '08143',
                '23' => '04081',
                '24' => '04081',
                '25' => '04083',
                '26' => '04083',
                '27' => '13101',
                '28' => '13103',
                '29' => '05103',
                '30' => '13091',
                '31' => '13091',
                '32' => '05131',
                '33' => '13093',
                '34' => '13421',
                '35' => '05131',
                '36' => '05131',
            ][$department_id] ?? '';
    }
}
