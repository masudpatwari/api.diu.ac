<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LiaisonOfficer;
use App\Employee;
use App\BillOnStudentAdmission;
use App\LiaisonOfficersSmsHistory;
use App\Rules\CheckValidPhoneNumber;
use App\Http\Resources\LiaisonOfficersResource;
use App\Http\Resources\LiaisonOfficersEditResource;
use Illuminate\Support\Facades\DB;
use App\Traits\RmsApiTraits;
use App\Liaison_programs;

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
        $this->validate($request,
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
        $this->validate($request,
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

        LiaisonOfficer::where('id', $id)->update([
                'deleted_at' => date('Y-m-d H:i:s', time()),
                'deleted_by' => $request->auth->id,
            ]
        );

        return response()->json(null, 200);

    }

    public function send_to_all(Request $request)
    {
        $this->validate($request,
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
        $this->validate($request,
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

                $stddata[$key]['amount'] = $this->get_amount_for_officer($std);

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

            $stddata['amount'] = $this->get_amount_for_officer($stddata);
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
            return Liaison_programs::where('name', $stddata['department']['name'])->first()->amount_liaison_local;

        } else {

            $ret = Liaison_programs::where('name', $stddata['department']['name'])->first()->amount_liaison_foreign;
            return $ret;

        }
    }

    public function get_amount_for_student($std)
    {
//         dump($std['department']['name']);
        // dd( Liaison_programs::where('name', trim($std['department']['name']))->first());

        if (strpos(strtolower($std['nationality']), 'ban') !== false) {
            return Liaison_programs::where('name', trim($std['department']['name']))->first()->amount_std_local;
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
        $bills = BillOnStudentAdmission::where('posted_to_erp', 0)->where('type', 'liaison_student')->get();
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
        $this->validate($request,
            [
                'student_id' => 'required|integer',
                'amount' => 'required|numeric',
                'receipt_no' => 'required',
            ]);

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
}
