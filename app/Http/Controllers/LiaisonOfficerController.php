<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LiaisonOfficer;
use App\Employee;
use App\Models\STD\Student;
use App\BillOnStudentAdmission;
use App\LiaisonOfficersSmsHistory;
use App\Rules\CheckValidPhoneNumber;
use App\Http\Resources\LiaisonOfficersResource;
use App\Http\Resources\LiaisonOfficersEditResource;
use Illuminate\Support\Facades\DB;
use App\Traits\RmsApiTraits;
use App\Liaison_programs;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;


class LiaisonOfficerController extends Controller
{
    use RmsApiTraits;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $officers = LiaisonOfficer::findliaisonofficers($request)->orderBy('id', 'asc');
        $results = $officers->paginate(30);

        if (!empty($results)) {
            return LiaisonOfficersResource::collection($results)->additional([
                'total' => LiaisonOfficer::count()
            ]);
        }
        return response()->json(NULL, 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'officer_name' => 'required',
                'email' => 'email',
                'mobile_no' => ['required', 'unique:liaison_officers,mobile1', new CheckValidPhoneNumber],
                'another_mobile_no' => ['unique:liaison_officers,mobile1', new CheckValidPhoneNumber],
            ]
        );

        $latest = LiaisonOfficer::orderBy('code', 'desc')->first();
        $max_code = 2000000;
        if (!empty($latest)) {
            $max_code = ($latest->code + 1);
        }

        $officer = LiaisonOfficer::create([
            'name' => $request->input('officer_name'),
            'fatherName' => $request->input('father_name'),
            'division' => $request->input('division_id'),
            'district' => $request->input('district_id'),
            'ps' => $request->input('police_station_id'),
            'address' => $request->input('address'),
            'occupation' => $request->input('occupation'),
            'institute' => $request->input('institute'),
            'email' => $request->input('email'),
            'mobile1' => $request->input('mobile_no'),
            'mobile2' => $request->input('another_mobile_no'),
            'code' => $max_code,
            'officerMobileNumber' => $request->input('dealing_officer_id'),
            'created_by' => $request->auth->id,

        ]);
        if (!empty($officer->id)) {
            return response()->json($officer, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    private function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $officer = LiaisonOfficer::where('id', $id)->first();


        if (!empty($officer)) {
            return new LiaisonOfficersEditResource($officer);
        }
        return response()->json(NULL, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'officer_name' => 'required',
                'email' => 'email',
                'mobile_no' => ['required', 'unique:liaison_officers,mobile1,' . $id, new CheckValidPhoneNumber],
                'another_mobile_no' => ['unique:liaison_officers,mobile1,' . $id, new CheckValidPhoneNumber],
            ]
        );
        try {
            DB::beginTransaction();

            $officer = LiaisonOfficer::where('id', $id)->update([
                'name' => $request->input('officer_name'),
                'fatherName' => $request->input('father_name'),
                'division' => $request->input('division_id'),
                'district' => $request->input('district_id'),
                'ps' => $request->input('police_station_id'),
                'address' => $request->input('address'),
                'occupation' => $request->input('occupation'),
                'institute' => $request->input('institute'),
                'email' => $request->input('email'),
                'mobile1' => $request->input('mobile_no'),
                'mobile2' => $request->input('another_mobile_no'),
                'officerMobileNumber' => $request->input('dealing_officer_id'),
                'updated_by' => $request->auth->id,
                'payment_method' => $request->payment_method,
                'mobile_banking_number' => $request->mobile_banking_number,
            ]);

            DB::commit();
            return response()->json(NULL, 201);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Update Failed.' . $e], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        LiaisonOfficer::where('id', $id)->update(
            [
                'deleted_at' => date('Y-m-d H:i:s', time()),
                'deleted_by' => $request->auth->id,
            ]
        );

        return response()->json(null, 200);
    }

    public function send_to_all(Request $request)
    {
        $this->validate(
            $request,
            [
                'message' => 'required',
            ]
        );
        $search_items = ["[nameofofficer]", "[phoneofdealingofficer]", "[code]"];
        $message = $request->input('message');

        $officers = LiaisonOfficer::orderBy('id', 'asc')->get();
        foreach ($officers as $key => $officer) {
            if ($this->check_valid_mobile_no($officer->mobile1)) {
                $nameofofficer = $officer->name;
                $phoneofdealingofficer = $officer->officerMobileNumber;
                $code = $officer->code;

                $replace_items = [$nameofofficer, $phoneofdealingofficer, $code];
                $generate_message = str_replace($search_items, $replace_items, $message);

                $history[] = [
                    'message' => $generate_message,
                    'mobile_no' => $officer->mobile1,
                ];
            }
        }

        try {
            DB::beginTransaction();
            LiaisonOfficersSmsHistory::insert($history);
            DB::commit();
            return response()->json(NULL, 201);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Send SMS Failed.' . $e], 400);
        }
    }

    public function send_to_custom(Request $request)
    {
        $this->validate(
            $request,
            [
                'message' => 'required',
            ]
        );
        $search_items = ["[nameofofficer]", "[phoneofdealingofficer]", "[code]"];
        $message = $request->input('message');

        $officers = LiaisonOfficer::findliaisonofficers($request)->orderBy('id', 'asc')->get();
        foreach ($officers as $key => $officer) {
            if ($this->check_valid_mobile_no($officer->mobile1)) {
                $nameofofficer = $officer->name;
                $phoneofdealingofficer = $officer->officerMobileNumber;
                $code = $officer->code;

                $replace_items = [$nameofofficer, $phoneofdealingofficer, $code];
                $generate_message = str_replace($search_items, $replace_items, $message);

                $history[] = [
                    'message' => $generate_message,
                    'mobile_no' => $officer->mobile1,
                ];
            }
        }

        try {
            DB::beginTransaction();
            LiaisonOfficersSmsHistory::insert($history);
            DB::commit();
            return response()->json(NULL, 201);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Send SMS Failed.' . $e], 400);
        }
    }

    protected function check_valid_mobile_no($mobile_no)
    {
        $regx_code = "/(?:(^[+]?[(]?[0-9]{1,4}[)]?[-]?[0-9]{2,}([-0-9]{2,3})?(([\s\S]{5}[0-9]{2,4})?)?$)|(^\+{0,1}\d{8,}$)){1}/";
        return (preg_match($regx_code, $mobile_no) > 0) ? true : false;
    }

    public function bill_index(Request $request)
    {
        try {

            $stddata = self::traits_get_ref_student_for_liaison_officer();
            // dd($stddata);
            $liaisonCodes = array_column($stddata, 'ref_val');
            // $liaisonCodes = [2919854, 2919846] ;

            $liaisonCodes = array_filter($liaisonCodes, function ($value) {
                return !is_null($value) && $value !== '';
            });

            if (count($liaisonCodes) == 0) {
                return response()->json(['error' => 'No Liaison Officer Seted'], 400);
            }

            $officers = LiaisonOfficer::whereIn('code', $liaisonCodes)->get();

            if ($officers->count() == 0) {
                return response()->json('', 404);
            }

            $officersArray = [];
            foreach ($officers as $officer) {
                $officersArray[$officer->code] = $officer;
            }

            $printDoneStudentsArray = BillOnStudentAdmission::select('student_id')->get()->pluck('student_id')->toArray();

            foreach ($stddata as $key => $std) {

                $stddata[$key]['amount'] = $this->get_amount_for_officer($std) ?? 0;

                if (in_array($std['id'], $printDoneStudentsArray)) {
                    $stddata[$key]['printdone'] = true;
                } else {
                    $stddata[$key]['printdone'] = false;
                }
            }

            return response()->json(['students' => $stddata, 'officers' => $officersArray], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function print_bill_form(int $studentId)
    {

        try {
            $stddata = self::traits_get_single_ref_student_for_liaison_officer($studentId);

            $stddata['amount'] = $this->get_amount_for_officer($stddata) ?? 0;
            // dd($stddata);

            $liaisonCodes = $stddata['ref_val'];
            // $liaisonCodes = 2919846;

            $officer = LiaisonOfficer::where('code', $liaisonCodes)->first();

            if (!$officer) {
                return response()->json(['error' => 'Liaison Officer Not found'], 400);
            }

            $data['student'] = $stddata;
            $data['officer'] = $officer;

            $view = view('bill_for_stdents/bill_form', $data);

            $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->WriteHTML($view, 2);
            return $mpdf->Output('application_', 'I');
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function student_bill_index(Request $request)
    {
        try {

            $stddata = self::traits_get_ref_student_for_liaison_student();

            $printDoneStudentsArray = BillOnStudentAdmission::select('student_id')->get()->pluck('student_id')->toArray();

            foreach ($stddata as $key => $std) {

                $stddata[$key]['amount'] = $this->get_amount_for_student($std);

                if (in_array($std['id'], $printDoneStudentsArray)) {
                    $stddata[$key]['printdone'] = true;
                } else {
                    $stddata[$key]['printdone'] = false;
                }
            }

            return response()->json(['students' => $stddata], 200);
        } catch (\Exception $e) {

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response()->json([$e->getMessage()], 400);
        }
    }

    public function get_amount_for_officer($stddata)
    {

        if (strpos(trim(strtolower($stddata['nationality'])), 'ban') !== false) {
            return optional(Liaison_programs::where('name', $stddata['department']['name'])->first())
                ->amount_liaison_local;
        } else {

            $ret = Liaison_programs::where('name', $stddata['department']['name'])->first()->amount_liaison_foreign;
            return $ret;
        }
    }

    public function get_amount_for_student($std)
    {
        if (strpos(strtolower($std['nationality']), 'ban') !== false) {
            return optional(Liaison_programs::where('name', trim($std['department']['name']))->first())
                ->amount_std_local;
        } else {
            return Liaison_programs::where('name', trim($std['department']['name']))->first()->amount_std_foreign;
        }
    }


    public function print_scholarship_form(int $studentId)
    {

        try {

            $admittedStudent = self::traits_get_single_ref_student_for_liaison_student($studentId);

            $admittedByStudent = $admittedStudent['admittedByStd'];

            $admittedStudent['amount'] = $this->get_amount_for_student($admittedStudent);

            $data['admittedStudent'] = $admittedStudent;
            $data['admittedByStudent'] = $admittedByStudent;

            $view = view('bill_for_stdents/student_scholarship_form', $data);

            // return $view;
            $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->WriteHTML($view, 2);
            return $mpdf->Output('application_', 'I');
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function bill_print_done(int $studentId, string $type, int $personId)
    {
        $amount = 0;
        $student_detail = '';
        $person_detail = '';
        $admittedByStudent = null;

        $exists = BillOnStudentAdmission::where('student_id', $studentId)->first();

        if ($exists) {
            return response()->json(['error' => 'Already Printed'], 400);
        }

        // type = liaison_officer | liaison_student
        if ($type == 'liaison_officer') { // type = liaison_officer

            // stddata will be an array
            $stddata = self::traits_get_single_ref_student_for_liaison_officer($studentId);

            $liaisonCodes = $stddata['ref_val'];

            $officer = LiaisonOfficer::where('code', $liaisonCodes)->first();
            $person_detail .= 'ID# ' . $officer->id . '<br>';
            $person_detail .= $officer->name . '<br>';
            $person_detail .= $officer->institute . '<br>';
            $person_detail .= $officer->code . '<br>';
            $person_detail .= $officer->mobile1 . '<br>';

            $amount = $this->get_amount_for_officer($stddata);
        } else { // type = liaison_student
            // stddata will be an array
            $stddata = self::traits_get_single_ref_student_for_liaison_student($studentId);
            $admittedByStudent = $stddata['admittedByStd'];

            $person_detail .= 'ID# ' . $admittedByStudent['id'] . '<br>';
            $person_detail .= $admittedByStudent['name'] . '<br>';
            $person_detail .= $admittedByStudent['department']['name'] . '<br>';
            $person_detail .= $admittedByStudent['reg_code'] . '<br>';
            $person_detail .= 'Batch- ' . $admittedByStudent['batch']['batch_name'] . '<br>';
            $person_detail .= 'Roll# ' . $admittedByStudent['roll_no'] . '<br>';

            $amount = $this->get_amount_for_student($stddata);
        }


        $student_detail .= 'ID# ' . $stddata['id'] . '<br>';
        $student_detail .= $stddata['name'] . '<br>';
        $student_detail .= $stddata['department']['name'] . '<br>';
        $student_detail .= $stddata['reg_code'] . '<br>';
        $student_detail .= 'Batch- ' . $stddata['batch']['batch_name'] . '<br>';
        $student_detail .= 'Roll# ' . $stddata['roll_no'] . '<br>';

        $bill = new BillOnStudentAdmission();
        $bill->student_id = $studentId;
        $bill->type = $type;
        $bill->person_id = $personId;
        $bill->student_detail = $student_detail;
        $bill->person_detail = $person_detail;
        $bill->amount = $amount;
        $bill->save();
        return response()->json(['data' => $bill], 201);
    }

    public function billOnStudentAdmission($value = '')
    {
        return BillOnStudentAdmission::paginate(300);
    }


    public function student_scholarship_not_posted_in_erp()
    {
        $bills = BillOnStudentAdmission::where('posted_to_erp', 0)->where('type', 'liaison_student')->orderby('id', 'desc')->get();
        if ($bills->count() == 0) {
            return response()->json(['message' => 'No Bill found!'], 400);
        }

        return $bills;
    }

    public function student_scholarship_posted_in_erp()
    {
        $bills = BillOnStudentAdmission::where('posted_to_erp', 1)->where('type', 'liaison_student')->get();
        if ($bills->count() == 0) {
            return response()->json(['message' => 'No Bill found!'], 400);
        }

        return $bills;
    }

    public function saveStudentScholarshipAsLiaisonOfficer(Request $request)
    {
        $this->validate(
            $request,
            [
                'student_id' => 'required|integer',
                'amount' => 'required|numeric',
                'receipt_no' => 'required',
            ]
        );

        $student_id = $request->student_id;

        $responseArray = $this->save_student_scholarship_as_liaison_officer($request, $student_id, $request->amount, $request->receipt_no);

        if ($responseArray['status'] == 200) {
            BillOnStudentAdmission::where('person_id', $student_id)->update([
                'posted_to_erp' => '1',
                'posted_to_erp_date_time' => date("Y-m-d H:i:s"),
            ]);
        }

        return response()->json($responseArray['content'], $responseArray['status']);
    }

    public function get_student_scholarship_eligible()
    {

        $date =  "2024-07-15";
        // $endDate = date("Y-m-d");
        $student = BillOnStudentAdmission::where('posted_to_erp', 0)
            ->where('datetime', '>=',  $date )
            ->orderby('id', 'desc')
            ->get();
        if ($student->count() == 0) {
            return response()->json(['message' => 'No Bill found!'], 400);
        }

        return $student;
    }

    public function student_scholarship_eligible_store($id, $eligible_id)
    {
        $eligible =  BillOnStudentAdmission::find($id);

        if (!empty($eligible)) {
            $receipt_no = $eligible->student_id . '-' . $eligible->person_id;
            $eligible->update([
                'eligible_id' => $eligible_id,
                'eligible_status' => 1,
                'receipt_no' => $receipt_no,
            ]);

            return response()->json(['message' => 'Eligible Store Successfully Done.'], 200);
        } else {
            return response()->json(['error' => 'Not Found.'], 404);
        }
    }

    public function student_scholarship_eligible_calculate()
    {
        $date =  "2024-07-15";
        $endDate = date("Y-m-d");
        $bills = BillOnStudentAdmission::where('posted_to_erp', 0)
            ->where('eligible_status', 1)
            // ->whereBetween('datetime', [$startDate, $endDate])
            ->where('datetime', '>=',  $date )
            ->orderby('id', 'desc')
            ->get();
        if ($bills->count() == 0) {
            return response()->json(['message' => 'No Student found!'], 400);
        }

        return $bills;
    }

    public function student_scholarship_eligible_calculate_store(Request $request)
    {
        $this->validate(
            $request,
            [

                'admission_fee' => 'required',
                'tution_fee' => 'required',
                'scholarship_amount' => 'required',
                'scholarship_parcentage' => 'required',
            ]
        );
        // return $request->all();

        $student_id = $request->student_id;
        $amount1 = $request->amount1;
        if (empty($amount1)) {
            $amount1 = 0;
        }
        $amount2 = $request->amount2;
        if (empty($amount2)) {
            $amount2 = 0;
        }
        if ($request->scholarship_parcentage == 'special') {
            $scholarship_parcentage = $request->scholarship_parcentage;
        } else {
            $scholarship_parcentage = $request->scholarship_parcentage . '%';
        }

        // return $scholarship_parcentage;

        $eligible =  BillOnStudentAdmission::where('student_id', $student_id)->first();



        if (!empty($eligible)) {
            $eligible->update([
                'admission_fee' => $request->admission_fee,
                'tution_fee' => $request->tution_fee,
                'scholarship_amount' => $request->scholarship_amount,
                'scholarship_note' => $scholarship_parcentage,
                'amount1' => $amount1,
                'amount1_note' => $request->description1 ?? null,
                'amount2' => $amount2,
                'amount2_note' => $request->description2 ?? null,
                'number_of_semester' => $request->number_of_semester,
                'scholarship_type' => $request->scholarship_type,
                'eligible_status' => 2,

            ]);

            return response()->json(['message' => 'Scholarship Store Successfully Done.'], 200);
        } else {
            return response()->json(['error' => 'Not Found.'], 404);
        }
    }

    public function student_scholarship_eligible_fee_calculate($student_id)
    {

        $scholarship =  BillOnStudentAdmission::where('student_id', $student_id)->first();
        return $this->scolarship_calculation($scholarship);
    }

    public function scolarship_calculation($scholarship)
    {
        $student = $this->student_infos($scholarship->student_id);
        $admited_person = $this->student_infos($scholarship->person_id);
        $account = $this->student_account_info($scholarship->student_id);
        $sum_of_admission_fee = collect($account)->filter(function ($item) {
            return $item['purpose_pay_id'] == 4;
        })->sum('amount');

        // if ($scholarship->scholarship_type == 'special') {
        //     $total_payable =  $scholarship->tution_fee - ($scholarship->scholarship_amount + $scholarship->amount1 + $scholarship->amount2);
        // } else {
        //     $total_payable = ($scholarship->admission_fee + $scholarship->tution_fee) - ($scholarship->scholarship_amount + $scholarship->amount1 + $scholarship->amount2);
        // }
        $total_payable = ($scholarship->admission_fee + $scholarship->tution_fee) - ($scholarship->scholarship_amount + $scholarship->amount1 + $scholarship->amount2);


        $payable_semester = ($total_payable - $sum_of_admission_fee)  / $scholarship->number_of_semester;
        $payable_mid = $payable_semester / 2;
        $payable_final = $payable_semester / 2;

        return [
            'admission_fee' => $scholarship->admission_fee,
            'tution_fee' => $scholarship->tution_fee,
            'scholarship_amount' => $scholarship->scholarship_amount,
            'scholarship_note' => $scholarship->scholarship_note,
            'amount' => $scholarship->amount,
            'amount1' => $scholarship->amount1,
            'amount1_note' => $scholarship->amount1_note,
            'amount2' => $scholarship->amount2,
            'amount2_note' => $scholarship->amount2_note,
            'total_payable' => $total_payable,
            'sum_of_admission_fee' => $sum_of_admission_fee,
            'payable_mid' => ceil($payable_mid),
            'payable_final' => ceil($payable_final),
            'eligible_id' => $scholarship->eligible_id,
            'date' => date('Y-m-d', strtotime($scholarship->datetime)),
            'student' => $student,
            'person' => $admited_person,

        ];
    }


    public function student_scholarship_eligible_generate_pdf(Request $request, $student_id, $english, $program, $chair)
    {

        $data['english'] = Employee::select('id', 'name', 'office_email', 'personal_phone_no')->find($english);
        $data['program'] = Employee::select('id', 'name', 'office_email', 'personal_phone_no')->find($program);
        $data['chair'] = Employee::select('id', 'name', 'office_email', 'personal_phone_no')->find($chair);

        $info =  $this->student_scholarship_eligible_fee_calculate($student_id);
        $data['studentInfo'] = $info;

        $student_mail =  $this->createUser($info);
       

        // $student_mail = $createMail['userPrincipalName'];
        // $student_mail = $createMail;
        
        $data['email'] = $student_mail;

        $data['portal'] = $this->createStudentPortal($info, $student_mail);

        $data['employee'] = Employee::with('relDesignation')->select('id', 'name', 'office_email', 'designation_id')->find($request->auth->id);

        $view = view('bill_for_stdents/eligible_student_scholarship', $data)->render();

        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 33, 'margin_left' => 20, 'margin_right' => 15,]);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->SetDefaultBodyCSS('background', "url('https://api.diu.ac/images/pad.jpeg')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
        $mpdf->WriteHTML($view, 2);
        return $mpdf->Output($info['student']['name'] . '.pdf', 'I');
    }

    public function getAccessToken()
    {
        $tenantId = env('MICROSOFT_TENANT_ID');
        $clientId = env('MICROSOFT_CLIENT_ID');
        $clientSecret = env('MICROSOFT_CLIENT_SECRET');

        $client = new Client();
        $response = $client->post("https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token", [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => 'https://graph.microsoft.com/.default',
            ],
        ]);

        $body = json_decode($response->getBody());
        return $body->access_token;
    }

    public function createUser($info)
    {
        $client = new Client();
        $accessToken = $this->getAccessToken();

        $get_name =  $info['student']['name'];
        $get_dob =  $info['student']['dob'];
        $reg_code =  $info['student']['reg_code'];
        //   $reg_code =  "LL-D-66-23-124500";

        if (preg_match('/(\d+)-CT$/', $reg_code, $matches)) {
            $reg = $matches[1];
        } else {
            $parts = explode('-', $reg_code);
            $reg = end($parts);
        }


        $first_name = explode(' ', $get_name);
        $name = $first_name[1] ?? $first_name[0];
        $student_name = strtolower($name);
        $email = $student_name . $reg.'@students.diu.ac';
        $dob = substr($get_dob, 0, 4);



         $checkEmail =  $this->userExists($email);
        if (!empty($checkEmail)) {
            return $email;
            // $student_email = $email . $dob;
        } 

        $userData = [
            'accountEnabled' => true,
            'displayName' => $reg_code,
            'mailNickname' => $reg_code,
            'userPrincipalName' => $email,
            'passwordProfile' => [
                'forceChangePasswordNextSignIn' => false,
                'password' => ' Diu@12345',
            ],
        ];
        $response = $client->post('https://graph.microsoft.com/v1.0/users', [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => $userData,
        ]);

        $createMail = json_decode($response->getBody()->getContents(), true);

        return $createMail['userPrincipalName'];
    }

    public function userExists($email)
    {
        $client = new Client();
        $accessToken = $this->getAccessToken();
        // $email = $email . '@students.diu.ac';
        try {
            $response = $client->get("https://graph.microsoft.com/v1.0/users/$email", [
                'headers' => [
                    'Authorization' => "Bearer $accessToken",
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                return false;
            } else {
                throw $e;
            }
        }
    }

    public function createStudentPortal($info, $email)
    {
        $student_id =  $info['student']['id'];
        $check_student =  Student::find($student_id);

        if (empty($check_student)) {
            $student = new Student();
            $student->ID = $info['student']['id'];
            $student->NAME = $info['student']['name'];
            $student->REG_CODE = $info['student']['reg_code'];
            $student->ROLL_NO = $info['student']['roll_no'];
            $student->DEPARTMENT_ID = $info['student']['department_id'];
            $student->BATCH_ID = $info['student']['batch_id'];
            $student->SHIFT_ID = $info['student']['shift_id'];
            $student->GROUP_ID = $info['student']['group_id'];
            $student->BLOOD_GROUP = $info['student']['blood_group'];
            $student->EMAIL = $email;
            $student->PASSWORD = 'Diu@12345';
            $student->PHONE_NO = $info['student']['phone_no'];
            $student->ADM_FRM_SL = $info['student']['adm_frm_sl'];
            $student->GENDER = $info['student']['gender'];
            $student->DOB = $info['student']['dob'];
            $student->BIRTH_PLACE = $info['student']['birth_place'];
            $student->PARMANENT_ADD = $info['student']['parmanent_add'];
            $student->MAILING_ADD = $info['student']['mailing_add'];
            $student->F_NAME = $info['student']['f_name'];
            $student->F_CELLNO = $info['student']['f_cellno'];
            $student->F_OCCU = $info['student']['f_occu'];
            $student->M_NAME = $info['student']['m_name'];
            $student->M_CELLNO = $info['student']['m_cellno'];
            $student->M_OCCU = $info['student']['m_occu'];
            $student->E_NAME = $info['student']['e_name'];
            $student->E_CELLNO = $info['student']['e_cellno'];
            $student->E_OCCU = $info['student']['e_occu'];
            $student->ADM_DATE = $info['student']['adm_date'];
            $student->CAMPUS_ID = $info['student']['campus_id'];
            $student->IS_VERIFIED = 1;
            $student->save();

            return [
                'email' => $email,
                'password' => 'Diu@12345'
            ];
        } else {
            return [
                'email' => $check_student->EMAIL,
                'password' => $check_student->PASSWORD
            ];
        }
    }

    public function scholarship_eligible_student_info($student_id)
    {

        $eligible =  BillOnStudentAdmission::where('student_id', $student_id)->first();
        $student = $this->student_infos($student_id);
        $admit = $this->student_infos($eligible->person_id);

        return [

            'eligible' => $eligible,
            'student' => $student,
            'admit_by_id' => $admit['id'] ?? Null,
            'admit_by_reg' => $admit['reg_code'] ?? null

        ];
    }




    public function student_scholarship_eligible_search_final_posting($id)
    {
        $scholarship = BillOnStudentAdmission::where('posted_to_erp', 0)
            ->where('student_id', $id)
            ->where('eligible_status', 2)
            ->first();
        if ($scholarship->count() == 0) {
            return response()->json(['message' => 'No Student found!'], 404);
        }

        return $this->scolarship_calculation($scholarship);
    }

    public function student_scholarship_eligible_store_final_posting(Request $request, $student_id)
    {
         $eligible = BillOnStudentAdmission::where('student_id', $student_id)
            ->where('posted_to_erp', 0)
            ->where('eligible_status', 2)
            ->first();
            

        $office_email = Employee::findOrFail($request->auth->id)->office_email;
        // $office_email = 'masud@diu.ac';

        $student_id = $eligible->student_id;

        $student = $this->student_infos($student_id);

        $admited_by = $student['emp_id'];


        $scholarship = $eligible->scholarship_amount;
        $scholarship_note =  $eligible->scholarship_note;
        $scholarship_receipt_no = 'BOT' . $student_id;

        $amount1 = $eligible->amount1;
        $amount1_note = $eligible->amount1_note;
        $amount1_receipt_no =  'R1' . $student_id . 'BOT';

        $amount2 = $eligible->amount2;
        $amount2_note = $eligible->amount2_note;
        $amount2_receipt_no =  'R2' . $student_id . 'BOT';

        $responseArray =  $this->save_student_scholarship_in_erp($student_id, $scholarship, $scholarship_note, $scholarship_receipt_no, $office_email, $admited_by);

        if ($amount1 != 0) {
            $responseArray = $this->save_student_scholarship_in_erp($student_id, $amount1, $amount1_note, $amount1_receipt_no, $office_email, $admited_by);
        }
        if ($amount2 != 0) {
            $responseArray = $this->save_student_scholarship_in_erp($student_id, $amount2, $amount2_note, $amount2_receipt_no, $office_email, $admited_by);
        }

        if ($eligible->eligible_id == $eligible->person_id && $eligible->type == 'liaison_student') {
            $student_id = $eligible->person_id;
            $amount = $eligible->amount;
            $receipt_no = $eligible->receipt_no;
            $note = '';
            $responseArray = $this->save_student_scholarship_in_erp($student_id, $amount, $note, $receipt_no,  $office_email, $admited_by);
        }


        if ($responseArray['status'] == 200) {
            $eligible->update([
                'posted_to_erp' => 1,
                'posted_to_erp_date_time' => date("Y-m-d H:i:s"),
            ]);

            return response()->json(['message' => 'Scholarship Store Successfully'], 200);
        } else {
            return response()->json(['error' => 'Transection Fail!'], 404);
        }
    }

    public function save_student_scholarship_in_erp($stdId, $amount, $note, $receipt_no, $office_email, $admited_by)
    {


        $data = [
            'std_id' => $stdId,
            'amount' => $amount,
            'office_email' => $office_email,
            'receipt_no' => $receipt_no,
            'note' => $note,
            'admited_by' => $admited_by,
        ];


        $url = '' . env('RMS_API_URL') . '/save-eligible-student-scholarship';

        $response = Curl::to($url)
            ->withData($data)
            ->returnResponseObject()
            ->asJson(true)->post();

        return [
            'content' => $response->content,
            'status' => $response->status
        ];
    }


    public function store_new_admision_student_for_scholarship()
    {
        $amount = 0;
        $student_detail = '';
        $person_detail = '';

        $students = $this->traits_get_new_admission_student();
        if ($students) {
            foreach ($students as $student) {
                $exists = BillOnStudentAdmission::where('student_id', $student['id'])->first();

                if (empty($exists)) {
                    $person_detail = '';
                    $student_detail = '';

                    // Check if there's a liaison officer with the specified code
                    $officer = LiaisonOfficer::where('code', $student['ref_val'])->first();

                    if ($officer) {
                        // Populate person details for officer
                        $person_detail .= 'ID# ' . $officer->id . '<br>';
                        $person_detail .= $officer->name . '<br>';
                        $person_detail .= $officer->institute . '<br>';
                        $person_detail .= $officer->code . '<br>';
                        $person_detail .= $officer->mobile1 . '<br>';

                        $amount = 0; // Set amount for liaison officer
                        $type = 'liaison_officer';
                        $personId = 0; // Set person ID for liaison officer (if needed)
                    } elseif (isset($student['admittedByStd']['id']) && $student['admittedByStd']['id'] != null) {
                        // Populate person details for admitted student
                        $person_detail .= 'ID# ' . $student['admittedByStd']['id'] . '<br>';
                        $person_detail .= $student['admittedByStd']['name'] . '<br>';
                        $person_detail .= $student['admittedByStd']['department']['name'] . '<br>';
                        $person_detail .= $student['admittedByStd']['reg_code'] . '<br>';
                        $person_detail .= 'Batch- ' . $student['admittedByStd']['batch']['batch_name'] . '<br>';
                        $person_detail .= 'Roll# ' . $student['admittedByStd']['roll_no'] . '<br>';

                        $amount = $this->get_amount_for_student($student); // Calculate amount for student
                        $type = 'liaison_student';
                        $personId = $student['admittedByStd']['id']; // Set person ID for student
                    } else {
                        // Handle case where neither officer nor student details are available
                        $type = 'general';
                        $amount = 0;
                        $personId = 0;
                    }

                    // Populate student details
                    $student_detail .= 'ID# ' . $student['id'] . '<br>';
                    $student_detail .= $student['name'] . '<br>';
                    $student_detail .= $student['department']['name'] . '<br>';
                    $student_detail .= $student['reg_code'] . '<br>';
                    $student_detail .= 'Batch- ' . $student['batch']['batch_name'] . '<br>';
                    $student_detail .= 'Roll# ' . $student['roll_no'] . '<br>';

                    // Create new bill instance and save
                    // $bill = new BillOnStudentAdmission();
                    // $bill->student_id = $student['id'];
                    // $bill->type = $type;
                    // $bill->person_id = $personId;
                    // $bill->student_detail = $student_detail;
                    // $bill->person_detail = $person_detail;
                    // $bill->amount = $amount;
                    // $bill->save();
                }
            }
        }



        return response()->json(['message' => 'Insert Successfully Done'], 201);
    }

    public function traits_get_new_admission_student()
    {

        $url = '' . env('RMS_API_URL') . '/get_new_admission_students';
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        if ($response->status == 200) {
            return $response->content;
        }
        throw new \Exception("Student not found", 1);
    }


    public function student_scholarship_eligible_final_posting_qrcode($start_date,$end_date){
          $start_date = Carbon::parse($start_date)->startOfDay();
          $end_date = Carbon::parse($end_date)->endOfDay();

         $eligibles = BillOnStudentAdmission::where('posted_to_erp', 0)
            ->whereBetween('datetime', [$start_date, $end_date])
            ->where('eligible_status', 2)
            ->get();

            if (!$eligibles->isEmpty()) {
                $data = $eligibles->map(function ($eligible) {
                    $std = $this->student_infos($eligible->student_id);
                    return [
                        'id' => $std['id'],
                        'name' => $std['name'],
                        'reg_code' => $std['reg_code'],
                        'roll' => $std['roll_no'],
                        'department' => $std['department']['name'],
                        'batch' => $std['batch']['batch_name'],
                    ];
                });
            
                return $data;  
                
            }else{
                return response()->json(['message' => 'No Student found!'], 404);
            }
            

            
        



    }

    public function student_scholarship_eligible_final_posting_qrcode_pdf($start_date,$end_date){
        $start_date = Carbon::parse($start_date)->startOfDay();
        $end_date = Carbon::parse($end_date)->endOfDay();

       $eligibles = BillOnStudentAdmission::where('posted_to_erp', 0)
          ->whereBetween('datetime', [$start_date, $end_date])
          ->where('eligible_status', 2)
          ->get();
        
       $data = $eligibles->map(function ($eligible) {
            $std = $this->student_infos($eligible->student_id);
            return [
                'student_id' => $std['id'],
                'name' => $std['name'],
                'reg_code' => $std['reg_code'],
                'roll' => $std['roll_no'],
                'department' => $std['department']['name'],
                'batch' => $std['batch']['batch_name'],
            ];
        });
       

        $view = view('bill_for_stdents/eligible_student_final_posting_qrcode_generate',['data' => $data]);
        
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 1,'margin_bottom' => 1,'margin_left' => 1, 'margin_right' => 1,]);
       
        $mpdf->WriteHTML($view, 2);
        return $mpdf->Output( 'test.pdf', 'I');
            
          



    }
}
