<?php

namespace App\Http\Controllers\Accounts;

use App\Docmtg;
use App\Employee;
use App\Models\Cms\OtherStudentForm;
use App\Models\Cms\OtherStudentFormConvocationSecondDegree;
use App\Models\Cms\OtherStudentFormMidTermRetake;
use App\Models\Cms\OtherStudentFormResearch;
use App\Models\Cms\OtherStudentFormStatus;
use App\Rules\CheckValidDate;
use App\Traits\DocmtgTraits;
use App\Traits\MetronetSmsTraits;
use App\Traits\OtherApplicationForm;
use App\Traits\RmsApiTraits;
use App\Transcript;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Ixudra\Curl\Facades\Curl;
use App\Models\Convocation\StudentConvocation;
use App\Models\STD\Student;
use Illuminate\Support\Facades\Storage;


class OthersFormDownloadController extends Controller
{
    use RmsApiTraits;
    use OtherApplicationForm;
    use MetronetSmsTraits;
    use DocmtgTraits;

    public function food_token()
    {

        $convocations = Employee::where('activestatus', 1)->with('relDesignation')->where('id', '<>', 1)->paginate(104);

        $details = $convocations->map(function ($item, $index) {

                try {
                    $url = env("APP_URL") . "images/profile_photo_file_" . $item->id . ".jpg";

                    file_get_contents($url);
                } catch (\Exception $exception) {

                    $url = storage_path('assets/logo.png');
                }
//            }

            return [
                'Name' => $item->name,
                'Registration' => $item->relDesignation->name,
                'ID' => $item->id,
                'Image' => $url,
                'Serial' => '7CDIUS' . (str_pad($item->id, 4, '0', STR_PAD_LEFT)),
                'Url' => 'https://profile.diu.ac/' . $item->slug_name
            ];
        });



        return
        $view = view('food_token_pdf', compact('details'));
    }

    public function food_token_page($id)
    {

        if($id) {
            $convocations = Employee::where('activestatus', 1)->with('relDesignation')->where('id', '<>', 1)->skip
                (104*$id)->take(104)->get();
        }
//        $convocations = Employee::where('activestatus', 1)->with('relDesignation')->where('id', '<>', 1)->paginate(104);

        $details = $convocations->map(function ($item, $index) {

                try {
                    $url = env("APP_URL") . "images/profile_photo_file_" . $item->id . ".jpg";

                    file_get_contents($url);
                } catch (\Exception $exception) {

                    $url = storage_path('assets/logo.png');
                }
//            }

            return [
                'Name' => $item->name,
                'Registration' => $item->relDesignation->name,
                'ID' => $item->id,
                'Image' => $url,
                'Serial' => '7CDIUS' . (str_pad($item->id, 4, '0', STR_PAD_LEFT)),
                'Url' => 'https://profile.diu.ac/' . $item->slug_name
            ];
        });



        return
        $view = view('food_token_pdf', compact('details'));
    }

    public function food_token_experiment($id)
    {

//        if($id) {
            $convocations = Employee::where('activestatus', 1)->with('relDesignation')->where('id', '>', $id)->take(104)
                ->get();
//        }
//        $convocations = Employee::where('activestatus', 1)->with('relDesignation')->where('id', '<>', 1)->paginate(104);

        $details = $convocations->map(function ($item, $index) {

                try {
                    $url = env("APP_URL") . "images/profile_photo_file_" . $item->id . ".jpg";

                    file_get_contents($url);
                } catch (\Exception $exception) {

                    $url = storage_path('assets/logo.png');
                }
//            }

            return [
                'Name' => $item->name,
                'Registration' => $item->relDesignation->name,
                'ID' => $item->id,
                'Image' => $url,
                'Serial' => '7CDIUS' . (str_pad($item->id, 4, '0', STR_PAD_LEFT)),
                'Url' => 'https://profile.diu.ac/' . $item->slug_name
            ];
        });



        return
        $view = view('food_token_experiment', compact('details'));
    }

    public function convocation_ticket()
    {
        $convocations = StudentConvocation::where('confirmed', 1)->whereNull('serial')
            ->take(3)
            ->get();

        $details = $convocations->map(function ($item, $index) {

            $max_serial = StudentConvocation::max('serial');

            $null_serial = StudentConvocation::whereNull('serial')->where('id', $item->id)->first();

            if ($null_serial) {
                $serial = $max_serial + 1;
                $null_serial->update([
                    'serial' => $max_serial + 1
                ]);
            } else {
                $serial = $item->serial;
            }

            try {
                if (Storage::disk('attendance_info')->exists($item->image_url)) {
                    $url = env("APP_URL") . "images/convocations/" . $item->image_url;
                }

                file_get_contents($url);
            } catch (\Exception $exception) {

                try {
                    $url = env("APP_URL") . "images/convocations/" . $item->image_url;

                    file_get_contents($url);
                } catch (\Exception $exception) {

                    $url = storage_path('assets/logo.png');
                }
            }

            return [
                'Name' => $item->student_name,
                'Registration' => $item->reg_code_one,
                'ID' => $item->id,
                'Image' => $url,
                'Serial' => '7CDIU' . (str_pad($serial, 4, '0', STR_PAD_LEFT)),
                'Url' => 'https://diu.ac/convocations/7/' . $item->id
            ];
        });


        return

            $view = view('otherDownloadForm.convocation_ticket_pdf', compact('details'));
    }

    public function single_convocation_ticket($serial)
    {

        $convocation = StudentConvocation::where('serial', $serial)->first();

        // $detail = 


        try {
            if (Storage::disk('attendance_info')->exists($convocation->image_url)) {
                $url = env("APP_URL") . "images/convocations/" . $convocation->image_url;
            }

            file_get_contents($url);
        } catch (\Exception $exception) {

            try {
                $url = env("APP_URL") . "images/convocations/" . $convocation->image_url;

                file_get_contents($url);
            } catch (\Exception $exception) {

                $url = storage_path('assets/logo.png');
            }
        }

        // return[
        //     $details['Name'] = $item->student_name;
        //     'Registration' => $item->reg_code_one,
        //     'Result' => $item->result_one,
        //     'ID' => $item->id,
        //     'Image' => $url,
        //     'URL' => 'https://diu.ac/convocations/7/'.$item->id,
        //     'Serial' => $serial
        // ];

        $detail = [
            'Name' => $convocation->student_name,
            'Registration' => $convocation->reg_code_one,
            'ID' => $convocation->id,
            'Image' => $url,
            'Serial' => '7CDIU' . (str_pad($serial, 4, '0', STR_PAD_LEFT)),
            'Url' => 'https://diu.ac/convocations/7/' . $convocation->id
        ];


        return

            // $view = view('otherDownloadForm.convocation_ticket', compact('details'));
            $view = view('otherDownloadForm.single_convocation_ticket_pdf', compact('detail'));


        // $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
        // $mpdf->curlAllowUnsafeSslRequests = true;
        // $mpdf->Image('images/diuac/editorImage/1648396654_DGJpaMIqf1.png', 0, 0, 210, 297, 'png', '', true, true);
        // // $mpdf->WriteHTML($view);
        // return $mpdf->Output('convocation_ticket', 'I');
    }


    public function convocation_info($id)
    {

        return
            $convocation = StudentConvocation::find($id);

    }

     public function original_certificate()
     {
        return view('download_form/original_certificate_pdf');
     }

    public function multiple_convocation_ticket($serial)
    {

        $serials = explode('-', $serial);


        $convocations = StudentConvocation::whereIn('serial', $serials)->get();

        $details = $convocations->map(function ($item, $index) {

            try {
                if (Storage::disk('attendance_info')->exists($item->image_url)) {
                    $url = env("APP_URL") . "images/convocations/" . $item->image_url;
                }

                file_get_contents($url);
            } catch (\Exception $exception) {

                try {
                    $url = env("APP_URL") . "images/convocations/" . $item->image_url;

                    file_get_contents($url);
                } catch (\Exception $exception) {

                    $url = storage_path('assets/logo.png');
                }
            }

            return [
                'Name' => $item->student_name,
                'Registration' => $item->reg_code_one,
                'ID' => $item->id,
                'Image' => $url,
                'Serial' => '7CDIU' . (str_pad($item->serial, 4, '0', STR_PAD_LEFT)),
                'Url' => 'https://diu.ac/convocations/7/' . $item->id
            ];
        });


        return

            // $view = view('otherDownloadForm.convocation_ticket', compact('details'));
            $view = view('otherDownloadForm.convocation_ticket_pdf', compact('details'));


    }


    //other application form
    public function store(Request $request)
    {

        $this->validate($request, [
            'form_name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'nullable',
        ]);

        if ($request->receipt_no && ($request->bank_id == 7 || $request->bank_id == 8 || $request->bank_id == 9) && \App\Models\Cms\OtherStudentForm::wherereceiptNo($request->receipt_no)->exists()) {
            return response()->json(['message' => 'This receipt no already used'], 406);
        }


        try {

            \DB::beginTransaction();


            $student = $this->studentInfoWithCompleteSemesterResult($request->student_id);
            $student_provisional_transcript = $this->student_provisional_transcript_marksheet_info_by_student_id($request->student_id);

            if (!array_key_exists('result_publish_date_of_last_semester', $student_provisional_transcript)) {
                if ($student_provisional_transcript->status == '400') {
                    $student_provisional_transcript = [];
                }
                $student_provisional_transcript['result_publish_date_of_last_semester'] = '';
            }

            $form = $request->all();

            unset($form['receipt_no']);
            unset($form['token']);
            unset($form['bank_payment_date']);

            $receipt_no = $request->receipt_no;
            if ($request->bank_id == 1 || $request->bank_id == 3 || $request->bank_id == 4 || $request->bank_id == 5) {
                $bankSlipCreate = $this->bankSlipCreate($request->purpose_id, $request->student_id, $student['student']['name'], $student['student']['reg_code'], $request->total_payable);

                $receipt_no = $bankSlipCreate['receipt_number'];
                $form['bank_slip_id'] = $bankSlipCreate['bank_slip_id'];
            }

            $form['name'] = $student['student']['name'];
            $form['created_by'] = $request->auth->id;

            $form['bank_payment_date'] = Carbon::parse($request->bank_payment_date)->format('Y-m-d');

            $form['reg_code'] = $student['student']['reg_code'];
            $form['roll'] = $student['student']['roll_no'];
            $form['cgpa'] = $student['student']['cgpa'] ?? 'Not Completed';
            $form['shift'] = $student['student']['shift']['name'];
            $form['session'] = $student['student']['session_name'];
            $form['passing_year'] = \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript['result_publish_date_of_last_semester']))->format('Y') ?? '';
            $form['email'] = $student['student']['email'];
            $form['mobile_no'] = $student['student']['phone_no'];
            $form['receipt_no'] = $receipt_no;
            $form['code'] = Str::random(12);

            $otherStudentForm = \App\Models\Cms\OtherStudentForm::create($form);

            // payment
            $url = env('RMS_API_URL') . '/general-payment';
            $array = [
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('d-m-Y'),
                'purpose_id' => $request->purpose_id,
                'receipt_no' => $receipt_no,
                'total_payable' => $request->total_payable,
                'employee_email' => $request->auth->office_email,
                'student_id' => $request->student_id,
                'note' => $request->note,
            ];


            $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

            $data = "";
            if ($response->status == 200) {

                $this->sendStudentSmsForFeeCollection($request->purpose_id, $request->student_id, $request->total_payable);
            }
            // payment

            \DB::commit();

            return response()->json(['message' => 'Form create Successfully', 'otherStudentForm' => $otherStudentForm], 200);
        } catch (\Exception $e) {
            \DB::rollBack();

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            // return response()->json(['message' => $e->getMessage()], 400);
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }


    //other application form
    public function test_store(Request $request)
    {

        $this->validate($request, [
            'form_name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'nullable',
        ]);

        if ($request->receipt_no && ($request->bank_id == 7 || $request->bank_id == 8 || $request->bank_id == 9) && \App\Models\Cms\OtherStudentForm::wherereceiptNo($request->receipt_no)->exists()) {
            return response()->json(['message' => 'This receipt no already used'], 406);
        }

        try {

            \DB::beginTransaction();


            $student = $this->studentInfoWithCompleteSemesterResult($request->student_id);
            $student_provisional_transcript = $this->student_provisional_transcript_marksheet_info_by_student_id($request->student_id);


            if (!array_key_exists('result_publish_date_of_last_semester', $student_provisional_transcript)) {
                if ($student_provisional_transcript->status == '400') {
                    $student_provisional_transcript = [];
                }
                $student_provisional_transcript['result_publish_date_of_last_semester'] = '';
            }

            $form = $request->all();

            unset($form['receipt_no']);
            unset($form['token']);
            unset($form['bank_payment_date']);

            $receipt_no = $request->receipt_no;
            if ($request->bank_id == 1 || $request->bank_id == 3 || $request->bank_id == 4 || $request->bank_id == 5) {
                $bankSlipCreate = $this->bankSlipCreate($request->purpose_id, $request->student_id, $student['student']['name'], $student['student']['reg_code'], $request->total_payable);

                $receipt_no = $bankSlipCreate['receipt_number'];
                $form['bank_slip_id'] = $bankSlipCreate['bank_slip_id'];
            }

            $form['name'] = $student['student']['name'];
            $form['created_by'] = $request->auth->id;

            $form['bank_payment_date'] = Carbon::parse($request->bank_payment_date)->format('Y-m-d');

            $form['reg_code'] = $student['student']['reg_code'];
            $form['roll'] = $student['student']['roll_no'];
            $form['cgpa'] = $student['student']['cgpa'] ?? 'Not Completed';
            $form['shift'] = $student['student']['shift']['name'];
            $form['session'] = $student['student']['session_name'];
            $form['passing_year'] = \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript['result_publish_date_of_last_semester']))->format('Y') ?? '';
            $form['email'] = $student['student']['email'];
            $form['mobile_no'] = $student['student']['phone_no'];
            $form['receipt_no'] = $receipt_no;
            $form['code'] = Str::random(12);


            try{

                $otherStudentForm = \App\Models\Cms\OtherStudentForm::create($form);

            }catch(\Exception $e){
                return response()->json(['message' => $e->getMessage()], 400);
            }


            // payment
            $url = env('RMS_API_URL') . '/general-payment';
            $array = [
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('d-m-Y'),
                'purpose_id' => $request->purpose_id,
                'receipt_no' => $receipt_no,
                'total_payable' => $request->total_payable,
                'employee_email' => $request->auth->office_email,
                'student_id' => $request->student_id,
                'note' => $request->note,
            ];


            $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

            $data = "";
            if ($response->status == 200) {

                $this->sendStudentSmsForFeeCollection($request->purpose_id, $request->student_id, $request->total_payable);
            }
            // payment

            \DB::commit();

            return response()->json(['message' => 'Form create Successfully', 'otherStudentForm' => $otherStudentForm], 200);
        } catch (\Exception $e) {
            \DB::rollBack();

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            // return response()->json(['message' => $e->getMessage()], 400);
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function storeOriginalCertificateForm(Request $request)
    {

        $this->validate($request, [
            'form_name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'nullable',
            'first_degree' => 'nullable',
            'second_degree' => 'nullable',
            'program' => 'required_if:second_degree,true',
            'major_in' => 'required_if:second_degree,true',
            'roll_no' => 'required_if:second_degree,true',
            'registration_no' => 'required_if:second_degree,true',
            'batch' => 'required_if:second_degree,true',
            's_session' => 'required_if:second_degree,true',
            'group' => 'required_if:second_degree,true',
            'duration_of_the_course' => 'required_if:second_degree,true',
            'shift' => 'required_if:second_degree,true',
            'passing_year' => 'required_if:second_degree,true',
            'result' => 'required_if:second_degree,true',
            'result_published_date' => 'required_if:second_degree,true',
        ]);


        if ($request->receipt_no && \App\Models\Cms\OtherStudentForm::wherereceiptNo($request->receipt_no)->exists()) {
            return response()->json(['message' => 'This receipt no already used'], 406);
        }


        try {

            \DB::beginTransaction();

            $student = $this->studentInfoWithCompleteSemesterResult($request->student_id);
            $student_provisional_transcript = $this->student_provisional_transcript_marksheet_info_by_student_id($request->student_id);


            if (!array_key_exists('result_publish_date_of_last_semester', $student_provisional_transcript)) {
                if ($student_provisional_transcript->status == '400') {
                    $student_provisional_transcript = [];
                }
                $student['student']['cgpa'] = 'No Cgpa';
                $student_provisional_transcript['result_publish_date_of_last_semester'] = '';
            }


            $first_degree = 1;
            $second_degree = 1;

            if (!$request->first_degree) {
                $first_degree = 0;
            }

            if (!$request->second_degree) {
                $second_degree = 0;
            }


            $receipt_no = $request->receipt_no;
            $bank_slip_id = null;

            if ($request->bank_id == 1 || $request->bank_id == 3 || $request->bank_id == 4 || $request->bank_id == 5) {
                $bankSlipCreate = $this->bankSlipCreate($request->purpose_id, $request->student_id, $student['student']['name'], $student['student']['reg_code'], $request->total_payable);

                $receipt_no = $bankSlipCreate['receipt_number'];
                $bank_slip_id = $bankSlipCreate['bank_slip_id'];
            }


            $otherStudentForm = \App\Models\Cms\OtherStudentForm::create([
                'name' => $student['student']['name'],
                'form_name' => $request->form_name,
                'department_id' => $request->department_id,
                'batch_id' => $request->batch_id,
                'student_id' => $request->student_id,
                'purpose_id' => $request->purpose_id,
                'total_payable' => $request->total_payable,
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('Y-m-d'),
                'note' => $request->note,
                'receipt_no' => $receipt_no,
                'created_by' => $request->auth->id,
                'reg_code' => $student['student']['reg_code'],
                'cgpa' => $student['student']['cgpa'],
                'shift' => $student['student']['shift']['name'],
                'session' => $student['student']['session_name'],
                'passing_year' => \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript['result_publish_date_of_last_semester']))->format('Y') ?? 'Unknown',
                'roll' => $student['student']['roll_no'],
                'mobile_no' => $student['student']['phone_no'],
                'email' => $student['student']['email'],
                'convocation_first_degree' => $first_degree,
                'convocation_second_degree' => $second_degree,
                'bank_slip_id' => $bank_slip_id,
                'code' => Str::random(12),
            ]);


            if ($second_degree == 1) {
                // OtherStudentFormConvocationSecondDegree::updateOrCreate([
                //     'registration_no' => $request->registration_no],
                // [
                OtherStudentFormConvocationSecondDegree::create([
                    'registration_no' => $request->registration_no,
                    'other_student_form_id' => $otherStudentForm->id,
                    'program' => $request->program,
                    'major_in' => $request->major_in,
                    'roll_no' => $request->roll_no,
                    'batch' => $request->batch,
                    'session' => $request->s_session,
                    'group' => $request->group,
                    'duration_of_the_course' => $request->duration_of_the_course,
                    'shift' => $request->shift,
                    'passing_year' => $request->passing_year,
                    'result' => $request->result,
                    'result_published_date' => strtotime($request->result_published_date) ? Carbon::parse($request->result_published_date)->format('Y-m-d') : 'Unknown',
                ]);
            }

            // payment
            $url = env('RMS_API_URL') . '/general-payment';
            $array = [
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('d-m-Y'),
                'purpose_id' => $request->purpose_id,
                'receipt_no' => $receipt_no,
                'total_payable' => $request->total_payable,
                'employee_email' => $request->auth->office_email,
                'student_id' => $request->student_id,
                'note' => $request->note,
            ];

            $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

            $data = "";
            // if ($response->status == 200) {

            //     $this->sendStudentSmsForFeeCollection($request->purpose_id, $request->student_id, $request->total_payable);
            // }
            // payment

            \DB::commit();

            return response()->json(['message' => 'Form create Successfully', 'otherStudentForm' => $otherStudentForm], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    public function application(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'form_name' => 'required',
            'name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'required_if:bank_id,7,8,9',
            'created_by' => 'required|integer',
            'reg_code' => 'required',
            'cgpa' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'passing_year' => 'required',
            'roll' => 'required',
        ]);
       
        // return $otherStudentForm = OtherStudentForm::find(6686);
       $otherStudentForm = OtherStudentForm::with('employee:id,name,designation_id', 'employee.relDesignation:id,name')->find($request->id);    

       

             $student = $this->traits_get_student_by_id($otherStudentForm->student_id);
        //   dd( $student);
        $student_account_info_summary = $this->student_account_info_summary($otherStudentForm->student_id);
        //qr code start
        $formId = $otherStudentForm->code . '-' . $otherStudentForm->id;
        $details = ($formId);
        //qr code end

        if ($otherStudentForm->form_name == 'Professional Short Course') {

            $view = view('otherDownloadForm/professional_short_course', compact('otherStudentForm', 'student', 'student_account_info_summary', 'details'));
        } elseif ($otherStudentForm->form_name == 'Provisional Certificate' || $otherStudentForm->form_name == 'Transcript / Mark Certificate') {

            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

                // return [$student];
                
           if($otherStudentForm->student_id == '1981
           ') {  
            
                // $url = env('RMS_API_URL') . '/admission/student-filter/' . $otherStudentForm->reg_code;
                // $curl = Curl::to($url)->returnResponseObject();
                // $curl->asJson(true);
                // $response = $curl->get();            
                // $student = $response->content;
            

               $view = view('otherDownloadForm/provisional_certificate', compact('student', 'student_provisional_transcript_marksheet_info', 'otherStudentForm', 'details'));

                try {
                    $this->mpdf_show($view);
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                    $view = view('otherDownloadForm/provisional_certificate_with_image', compact('student', 'student_provisional_transcript_marksheet_info', 'otherStudentForm', 'details', 'error'));
                    return                     $this->mpdf_show($view);

                }


           }
            $view = view('otherDownloadForm/provisional_certificate', compact('student', 'student_provisional_transcript_marksheet_info', 'otherStudentForm', 'details'));
        } elseif ($otherStudentForm->form_name == 'Convocation') {

          


            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

            if ($student_provisional_transcript_marksheet_info == false) {
                return response()->json('ERP data error', 400);
            }

            $otherStudentFormConvocationSecondDegree = OtherStudentFormConvocationSecondDegree::whereotherStudentFormId($otherStudentForm->id)->first();
            $view = view('otherDownloadForm/convocation', compact('student', 'otherStudentForm', 'student_provisional_transcript_marksheet_info', 'otherStudentFormConvocationSecondDegree', 'details'));
        } elseif ($otherStudentForm->form_name == 'Research /Internship / Project / Thesis') {


            $otherStudentFormResearch = OtherStudentFormResearch::whereotherStudentFormId($otherStudentForm->id)->first();

            $view = view('otherDownloadForm/research_internship_project_thesis', compact('student', 'otherStudentForm', 'otherStudentFormResearch', 'details'));
        } elseif ($otherStudentForm->form_name == 're-admission') {
            $view = view('otherDownloadForm/re_admission', compact('student', 'otherStudentForm', 'details'));
        } elseif ($otherStudentForm->form_name == 'mid-term-retake-examination-form') {

            $otherStudentFormMidTermRetake = OtherStudentFormMidTermRetake::whereotherStudentFormId($otherStudentForm->id)->get();


            $view = view('otherDownloadForm/mid_term_retake', compact('student', 'otherStudentForm', 'details', 'otherStudentFormMidTermRetake'));
        } elseif ($otherStudentForm->form_name == 'Original Certificate') {
            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

            if ($student_provisional_transcript_marksheet_info == false) {
                return response()->json('ERP data error', 400);
            }

//            return [$otherStudentForm];

            $otherStudentFormOriginalCertificateSecondDegree = OtherStudentFormConvocationSecondDegree::whereotherStudentFormId($otherStudentForm->id)->first();

            $view = view('download_form/original_certificate_pdf', compact('student', 'otherStudentForm', 'details', 'otherStudentFormOriginalCertificateSecondDegree', 'student_provisional_transcript_marksheet_info'));
        } else {

            $view = view('otherDownloadForm/application_form', compact('otherStudentForm', 'student', 'student_account_info_summary', 'details'));
        }

        return $this->mpdf_show($view);
    }


    public function nApplication(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'form_name' => 'required',
            'name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'required_if:bank_id,7,8,9',
            'created_by' => 'required|integer',
            'reg_code' => 'required',
            'cgpa' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'passing_year' => 'required',
            'roll' => 'required',
        ]);

        // $otherStudentForm = OtherStudentForm::find(48);
        $otherStudentForm = OtherStudentForm::with('employee:id,name,designation_id', 'employee.relDesignation:id,name')->find($request->id);

        $student = $this->traits_get_student_by_id($otherStudentForm->student_id);
        $student_account_info_summary = $this->student_account_info_summary($otherStudentForm->student_id);

        //qr code start
        $formId = $otherStudentForm->code . '-' . $otherStudentForm->id;
        $details = ($formId);
        //qr code end

        if ($otherStudentForm->form_name == 'Professional Short Course') {

            $view = view('otherDownloadForm/professional_short_course', compact('otherStudentForm', 'student', 'student_account_info_summary', 'details'));
        } elseif ($otherStudentForm->form_name == 'Provisional Certificate' || $otherStudentForm->form_name == 'Transcript / Mark Certificate') {
            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

            // return 'ok';
            //            if($otherStudentForm->student_id == '1790') {
//                return 'ok';
// //                return [$student, $otherStudentForm, $student_provisional_transcript_marksheet_info, $details];

//                return view('otherDownloadForm/provisional_certificate_test', compact('student', 'student_provisional_transcript_marksheet_info', 'otherStudentForm', 'details'));

//            }
            $view = view('otherDownloadForm/nprovisional_certificate', compact('student', 'student_provisional_transcript_marksheet_info', 'otherStudentForm', 'details'));
        } elseif ($otherStudentForm->form_name == 'Convocation') {

            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

            if ($student_provisional_transcript_marksheet_info == false) {
                return response()->json('ERP data error', 400);
            }

            $otherStudentFormConvocationSecondDegree = OtherStudentFormConvocationSecondDegree::whereotherStudentFormId($otherStudentForm->id)->first();

            $view = view('otherDownloadForm/convocation', compact('student', 'otherStudentForm', 'student_provisional_transcript_marksheet_info', 'otherStudentFormConvocationSecondDegree', 'details'));
        } elseif ($otherStudentForm->form_name == 'Research /Internship / Project / Thesis') {


            $otherStudentFormResearch = OtherStudentFormResearch::whereotherStudentFormId($otherStudentForm->id)->first();

            $view = view('otherDownloadForm/research_internship_project_thesis', compact('student', 'otherStudentForm', 'otherStudentFormResearch', 'details'));
        } elseif ($otherStudentForm->form_name == 're-admission') {
            $view = view('otherDownloadForm/re_admission', compact('student', 'otherStudentForm', 'details'));
        } elseif ($otherStudentForm->form_name == 'mid-term-retake-examination-form') {

            $otherStudentFormMidTermRetake = OtherStudentFormMidTermRetake::whereotherStudentFormId($otherStudentForm->id)->get();


            $view = view('otherDownloadForm/mid_term_retake', compact('student', 'otherStudentForm', 'details', 'otherStudentFormMidTermRetake'));
        } elseif ($otherStudentForm->form_name == 'Original Certificate') {
            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

            if ($student_provisional_transcript_marksheet_info == false) {
                return response()->json('ERP data error', 400);
            }

//            return [$otherStudentForm];

            $otherStudentFormOriginalCertificateSecondDegree = OtherStudentFormConvocationSecondDegree::whereotherStudentFormId($otherStudentForm->id)->first();

            $view = view('download_form/original_certificate_pdf', compact('student', 'otherStudentForm', 'details', 'otherStudentFormOriginalCertificateSecondDegree', 'student_provisional_transcript_marksheet_info'));
        } else {

            $view = view('otherDownloadForm/application_form', compact('otherStudentForm', 'student', 'student_account_info_summary', 'details'));
        }

        try {
            $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->showImageErrors = true;
            $mpdf->WriteHTML($view);

            return $mpdf->Output('scholarship_form', 'I');

        }catch (\Exception $e){
            $view = view('otherDownloadForm/provisional_certificate_with_image', compact('student', 'student_provisional_transcript_marksheet_info', 'otherStudentForm', 'details'));

            return $this->mpdf_show($view);
        }
    }
    public function test(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'form_name' => 'required',
            'name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'required_if:bank_id,7,8,9',
            'created_by' => 'required|integer',
            'reg_code' => 'required',
            'cgpa' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'passing_year' => 'required',
            'roll' => 'required',
        ]);

        //        $otherStudentForm = OtherStudentForm::find(48);
        $otherStudentForm = OtherStudentForm::with('employee:id,name,designation_id', 'employee.relDesignation:id,name')->find($request->id);

        $student = $this->traits_get_student_by_id($otherStudentForm->student_id);
        $student_account_info_summary = $this->student_account_info_summary($otherStudentForm->student_id);

        //qr code start
        $formId = $otherStudentForm->code . '-' . $otherStudentForm->id;
        $details = ($formId);
        //qr code end


        if ($otherStudentForm->form_name == 'Professional Short Course') {

            $view = view('otherDownloadForm/professional_short_course', compact('otherStudentForm', 'student', 'student_account_info_summary', 'details'));
        } elseif ($otherStudentForm->form_name == 'Provisional Certificate' || $otherStudentForm->form_name == 'Transcript / Mark Certificate') {


            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);
            // return [$student, $student_provisional_transcript_marksheet_info, $otherStudentForm, $details];
            $view = view('otherDownloadForm/provisional_certificate', compact('student', 'student_provisional_transcript_marksheet_info', 'otherStudentForm', 'details'));
            // return [$view];

        } elseif ($otherStudentForm->form_name == 'Convocation') {

            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

            if ($student_provisional_transcript_marksheet_info == false) {
                return response()->json('ERP data error', 400);
            }

            $otherStudentFormConvocationSecondDegree = OtherStudentFormConvocationSecondDegree::whereotherStudentFormId($otherStudentForm->id)->first();

            $view = view('otherDownloadForm/convocation', compact('student', 'otherStudentForm', 'student_provisional_transcript_marksheet_info', 'otherStudentFormConvocationSecondDegree', 'details'));
        } elseif ($otherStudentForm->form_name == 'Research /Internship / Project / Thesis') {


            $otherStudentFormResearch = OtherStudentFormResearch::whereotherStudentFormId($otherStudentForm->id)->first();

            $view = view('otherDownloadForm/research_internship_project_thesis', compact('student', 'otherStudentForm', 'otherStudentFormResearch', 'details'));
        } elseif ($otherStudentForm->form_name == 're-admission') {
            $view = view('otherDownloadForm/re_admission', compact('student', 'otherStudentForm', 'details'));
        } elseif ($otherStudentForm->form_name == 'mid-term-retake-examination-form') {

            $otherStudentFormMidTermRetake = OtherStudentFormMidTermRetake::whereotherStudentFormId($otherStudentForm->id)->get();

            $view = view('otherDownloadForm/mid_term_retake', compact('student', 'otherStudentForm', 'details', 'otherStudentFormMidTermRetake'));
        } else {

            // return [$otherStudentForm, $student, $student_account_info_summary, $details];
            return $view = view('otherDownloadForm/application_form', compact('otherStudentForm', 'student', 'student_account_info_summary', 'details'));
        }
    }

    public function report(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|integer',
            'form_name' => 'required',
            'name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'required_if:bank_id,7,8,9',
            'created_by' => 'required|integer',
            'reg_code' => 'required',
            'cgpa' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'passing_year' => 'required',
            'roll' => 'required',
        ]);

        $otherStudentForm = OtherStudentForm::find($request->id);

        $studentInfoWithCompleteSemesterResult = $this->studentInfoWithCompleteSemesterResult($otherStudentForm->student_id);

        $transcript = '';
        if ($otherStudentForm) {
            $transcript = Transcript::whereregcode(trim($studentInfoWithCompleteSemesterResult['student']['reg_code']))->exists();
        }

        $transcriptStatus = 'No';
        if ($transcript) {
            $transcriptStatus = 'Yes';
        }

        // if(isset($studentInfoWithCompleteSemesterResult->error))
        // {
        //     $studentInfoWithCompleteSemesterResult['total_paid'] = '';
        // }


        $view = view('otherDownloadForm/report', compact('otherStudentForm', 'studentInfoWithCompleteSemesterResult', 'transcriptStatus'));

        return $this->mpdf_show($view);
    }

    public function bankSlip(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|integer',
            'form_name' => 'required',
            'name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'required_if:bank_id,7,8,9',
            'created_by' => 'required|integer',
            'reg_code' => 'required',
            'cgpa' => 'required',
            'shift' => 'required',
            'session' => 'required',
            'passing_year' => 'required',
            'roll' => 'required',
        ]);


        if (!in_array($request->bank_id, [1, 3, 4, 5])) {
            return response()->json(['message' => "Bank Slip generate for only bank transaction"], 400);
        }

        $otherStudentForm = OtherStudentForm::find($request->id);
        $student = $this->traits_get_student_by_id($otherStudentForm->student_id);
        $bank_info = $this->bankInfo($otherStudentForm->bank_id);
        $purpose_info = $this->purposeInfo($otherStudentForm->purpose_id);


        $view = view('otherDownloadForm/bank_slip', compact('student', 'bank_info', 'purpose_info', 'otherStudentForm'));
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
        $mpdf->WriteHTML($view);
        return $mpdf->Output('bank_slip', 'I');
    }

    //only for convocation
    public function storeConvocation(Request $request)
    {

        $this->validate($request, [
            'form_name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'nullable',
            'first_degree' => 'nullable',
            'second_degree' => 'nullable',
            'program' => 'required_if:second_degree,true',
            'major_in' => 'required_if:second_degree,true',
            'roll_no' => 'required_if:second_degree,true',
            'registration_no' => 'required_if:second_degree,true',
            'batch' => 'required_if:second_degree,true',
            's_session' => 'required_if:second_degree,true',
            'group' => 'required_if:second_degree,true',
            'duration_of_the_course' => 'required_if:second_degree,true',
            'shift' => 'required_if:second_degree,true',
            'passing_year' => 'required_if:second_degree,true',
            'result' => 'required_if:second_degree,true',
            'result_published_date' => 'required_if:second_degree,true',
        ]);


        if ($request->receipt_no && \App\Models\Cms\OtherStudentForm::wherereceiptNo($request->receipt_no)->exists()) {
            return response()->json(['message' => 'This receipt no already used'], 406);
        }


        try {

            \DB::beginTransaction();

            $student = $this->studentInfoWithCompleteSemesterResult($request->student_id);
            $student_provisional_transcript = $this->student_provisional_transcript_marksheet_info_by_student_id($request->student_id);


            if (!array_key_exists('result_publish_date_of_last_semester', $student_provisional_transcript)) {
                if ($student_provisional_transcript->status == '400') {
                    $student_provisional_transcript = [];
                }
                $student['student']['cgpa'] = 'No Cgpa';
                $student_provisional_transcript['result_publish_date_of_last_semester'] = '';
            }


            $first_degree = 1;
            $second_degree = 1;

            if (!$request->first_degree) {
                $first_degree = 0;
            }

            if (!$request->second_degree) {
                $second_degree = 0;
            }


            $receipt_no = $request->receipt_no;
            $bank_slip_id = null;

            if ($request->bank_id == 1 || $request->bank_id == 3 || $request->bank_id == 4 || $request->bank_id == 5) {
                $bankSlipCreate = $this->bankSlipCreate($request->purpose_id, $request->student_id, $student['student']['name'], $student['student']['reg_code'], $request->total_payable);

                $receipt_no = $bankSlipCreate['receipt_number'];
                $bank_slip_id = $bankSlipCreate['bank_slip_id'];
            }


            $otherStudentForm = \App\Models\Cms\OtherStudentForm::create([
                'name' => $student['student']['name'],
                'form_name' => $request->form_name,
                'department_id' => $request->department_id,
                'batch_id' => $request->batch_id,
                'student_id' => $request->student_id,
                'purpose_id' => $request->purpose_id,
                'total_payable' => $request->total_payable,
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('Y-m-d'),
                'note' => $request->note,
                'receipt_no' => $receipt_no,
                'created_by' => $request->auth->id,
                'reg_code' => $student['student']['reg_code'],
                'cgpa' => $student['student']['cgpa'],
                'shift' => $student['student']['shift']['name'],
                'session' => $student['student']['session_name'],
                'passing_year' => \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript['result_publish_date_of_last_semester']))->format('Y') ?? 'Unknown',
                'roll' => $student['student']['roll_no'],
                'mobile_no' => $student['student']['phone_no'],
                'email' => $student['student']['email'],
                'convocation_first_degree' => $first_degree,
                'convocation_second_degree' => $second_degree,
                'bank_slip_id' => $bank_slip_id,
                'code' => Str::random(12),
            ]);


            if ($second_degree == 1) {
                OtherStudentFormConvocationSecondDegree::create([
                    'other_student_form_id' => $otherStudentForm->id,
                    'program' => $request->program,
                    'major_in' => $request->major_in,
                    'roll_no' => $request->roll_no,
                    'registration_no' => $request->registration_no,
                    'batch' => $request->batch,
                    'session' => $request->s_session,
                    'group' => $request->group,
                    'duration_of_the_course' => $request->duration_of_the_course,
                    'shift' => $request->shift,
                    'passing_year' => $request->passing_year,
                    'result' => $request->result,
                    'result_published_date' => strtotime($request->result_published_date) ? Carbon::parse($request->result_published_date)->format('Y-m-d') : 'Unknown',
                ]);
            }

            // payment
            $url = env('RMS_API_URL') . '/general-payment';
            $array = [
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('d-m-Y'),
                'purpose_id' => $request->purpose_id,
                'receipt_no' => $receipt_no,
                'total_payable' => $request->total_payable,
                'employee_email' => $request->auth->office_email,
                'student_id' => $request->student_id,
                'note' => $request->note,
            ];

            $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

            $data = "";
            if ($response->status == 200) {

                $this->sendStudentSmsForFeeCollection($request->purpose_id, $request->student_id, $request->total_payable);
            }
            // payment

            \DB::commit();

            return response()->json(['message' => 'Form create Successfully', 'otherStudentForm' => $otherStudentForm], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 401);
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    //only for re admission
    public function storeResearch(Request $request)
    {
        $this->validate($request, [
            'form_name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'nullable',
            'title' => 'required',
            'organization' => 'required',
            'supervisor' => 'required',
            'co_supervisor' => 'nullable',
            'address' => 'required',
            'interest_field' => 'required|array',
        ]);

        if ($request->receipt_no && \App\Models\Cms\OtherStudentForm::wherereceiptNo($request->receipt_no)->exists()) {
            return response()->json(['message' => 'This receipt no already used'], 406);
        }

        try {

            \DB::beginTransaction();

            $student = $this->studentInfoWithCompleteSemesterResult($request->student_id);

            $student_provisional_transcript = $this->student_provisional_transcript_marksheet_info_by_student_id($request->student_id);


            $receipt_no = $request->receipt_no;
            $bank_slip_id = null;

            if ($request->bank_id == 1 || $request->bank_id == 3 || $request->bank_id == 4 || $request->bank_id == 5) {
                $bankSlipCreate = $this->bankSlipCreate($request->purpose_id, $request->student_id, $student['student']['name'], $student['student']['reg_code'], $request->total_payable);

                $receipt_no = $bankSlipCreate['receipt_number'];
                $bank_slip_id = $bankSlipCreate['bank_slip_id'];
            }

            $otherStudentForm = \App\Models\Cms\OtherStudentForm::create([
                'name' => $student['student']['name'],
                'form_name' => $request->form_name,
                'department_id' => $request->department_id,
                'batch_id' => $request->batch_id,
                'student_id' => $request->student_id,
                'purpose_id' => $request->purpose_id,
                'total_payable' => $request->total_payable,
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('Y-m-d'),
                'note' => $request->note,
                'receipt_no' => $receipt_no,
                'created_by' => $request->auth->id,
                'reg_code' => $student['student']['reg_code'],
                'cgpa' => $student['student']['cgpa'],
                'shift' => $student['student']['shift']['name'],
                'session' => $student['student']['session_name'],
                'passing_year' => \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript['result_publish_date_of_last_semester']))->format('Y'),
                'roll' => $student['student']['roll_no'],
                'mobile_no' => $student['student']['phone_no'],
                'email' => $student['student']['email'],
                'bank_slip_id' => $bank_slip_id,
                'code' => Str::random(12),

            ]);

            OtherStudentFormResearch::create([
                'other_student_form_id' => $otherStudentForm->id,
                'title' => $request->title,
                'organization' => $request->organization,
                'supervisor' => $request->supervisor,
                'co_supervisor' => $request->co_supervisor,
                'address' => $request->address,
                'interest_field' => $request->interest_field,
            ]);


            // payment
            $url = env('RMS_API_URL') . '/general-payment';
            $array = [
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('d-m-Y'),
                'purpose_id' => $request->purpose_id,
                'receipt_no' => $receipt_no,
                'total_payable' => $request->total_payable,
                'employee_email' => $request->auth->office_email,
                'student_id' => $request->student_id,
                'note' => $request->note,
            ];

            $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

            $data = "";
            if ($response->status == 200) {

                $this->sendStudentSmsForFeeCollection($request->purpose_id, $request->student_id, $request->total_payable);
            }

            // payment
            \DB::commit();

            return response()->json(['message' => 'Form create Successfully', 'otherStudentForm' => $otherStudentForm], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    //only for re mid term retake
    public function storeMidTermRetakeExaminationForm(Request $request)
    {
        //        dump(\Log::error(print_r($request->all(), true)));

        $this->validate($request, [
            'form_name' => 'required',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'total_payable' => 'required|integer',
            'bank_id' => 'required|integer',
            'bank_payment_date' => 'required',
            'note' => 'nullable',
            'receipt_no' => 'nullable',
            'semester' => 'required|integer',
            'retake' => 'required|array',
        ]);


        if ($request->receipt_no && \App\Models\Cms\OtherStudentForm::wherereceiptNo($request->receipt_no)->exists()) {
            return response()->json(['message' => 'This receipt no already used'], 406);
        }

        try {

            \DB::beginTransaction();

            $student = $this->studentInfoWithCompleteSemesterResult($request->student_id);
            // return $student;
            // dd($student);
            // return [$student];
            if (array_key_exists('error', $student)) {
                $student_provisional_transcript['result_publish_date_of_last_semester'] = '';
                $info_of_student = $student['student'];
            }

            if (!array_key_exists('cgpa', $info_of_student)) {
                $student['student']['cgpa'] = 'N/A';
                // return $student;

            }

            if (!$info_of_student['session_name']) {
                $student['student']['session_name'] = $info_of_student['batch']['sess'];
                // return $info_of_student;
            }

            $student_provisional_transcript = $this->student_provisional_transcript_marksheet_info_by_student_id($request->student_id);

            // dd($student_provisional_transcript);
            // return $student_provisional_transcript;

            $receipt_no = $request->receipt_no;
            $bank_slip_id = null;


            if ($request->bank_id == 1 || $request->bank_id == 3 || $request->bank_id == 4 || $request->bank_id == 5) {
                $bankSlipCreate = $this->bankSlipCreate($request->purpose_id, $request->student_id, $student['student']['name'], $student['student']['reg_code'], $request->total_payable);

                $receipt_no = $bankSlipCreate['receipt_number'];
                $bank_slip_id = $bankSlipCreate['bank_slip_id'];
            }

            $otherStudentForm = \App\Models\Cms\OtherStudentForm::create([
                'name' => $student['student']['name'],
                'form_name' => $request->form_name,
                'department_id' => $request->department_id,
                'batch_id' => $request->batch_id,
                'student_id' => $request->student_id,
                'purpose_id' => $request->purpose_id,
                'total_payable' => $request->total_payable,
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('Y-m-d'),
                'note' => $request->note,
                'receipt_no' => $receipt_no,
                'created_by' => $request->auth->id,
                'reg_code' => $student['student']['reg_code'],
                'cgpa' => $student['student']['cgpa'],
                'shift' => $student['student']['shift']['name'],
                'session' => $student['student']['session_name'],
                'passing_year' => \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript['result_publish_date_of_last_semester']))->format('Y'),
                'roll' => $student['student']['roll_no'],
                'mobile_no' => $student['student']['phone_no'],
                'email' => $student['student']['email'],
                'bank_slip_id' => $bank_slip_id,
                'semester' => $request->semester,
                'code' => Str::random(12),
            ]);

            $data = [];

            foreach ($request->retake as $row) {
                $data[] = [
                    'other_student_form_id' => $otherStudentForm->id,
                    'course_code' => $row['course_code'],
                    'course_name' => $row['course_name'],
                ];
            }

            OtherStudentFormMidTermRetake::insert($data);

            // return $otherStudentForm;

            // payment
            $url = env('RMS_API_URL') . '/general-payment';
            $array = [
                'bank_id' => $request->bank_id,
                'bank_payment_date' => Carbon::parse($request->bank_payment_date)->format('d-m-Y'),
                'purpose_id' => $request->purpose_id,
                'receipt_no' => $receipt_no,
                'total_payable' => $request->total_payable,
                'employee_email' => $request->auth->office_email,
                'student_id' => $request->student_id,
                'note' => $request->note,
            ];

            $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

            $data = "";
            if ($response->status == 200) {

                $this->sendStudentSmsForFeeCollection($request->purpose_id, $request->student_id, $request->total_payable);
            }
            // payment
            \DB::commit();

            return response()->json(['message' => 'Form create Successfully', 'otherStudentForm' => $otherStudentForm], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    public function mpdf_show($view)
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->showImageErrors = true;
        $mpdf->WriteHTML($view);
        return $mpdf->Output('scholarship_form', 'I');
    }

    public function sendStudentSmsForFeeCollection($purpose_id, $student_id, $total_payable)
    {
        if (!Cache::has('rms_get_purpose_pay')) {
            $this->get_purpose_pay();
        }

        $result = Cache::get('rms_get_purpose_pay');
        $purpose_id = $purpose_id;
        $perpose = collect($result)->filter(function ($item) use ($purpose_id) {

            return $item->id == $purpose_id;
        })->values();
        $perposeName = $perpose[0]->name ?? 'N/A';

        $student = $this->traits_get_student_by_id($student_id);

        $message = "Dear {$student->name} Received TK. {$total_payable}/- as {$perposeName} DIU";
        $this->send_sms($student->phone_no, $message);
    }

    public function bankSlipCreate($purpose_id, $student_id, $student_name, $student_reg_code, $total_payable)
    {

        $purpose_info = $this->purposeInfo($purpose_id);

        /*$digits = 7; $receipt_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);*/

        $last_bank_slip = \App\Models\STD\BankSlip::dsc()->first();
        $receipt_number = str_pad($last_bank_slip->id + 1, 7, '0', STR_PAD_LEFT);

        $bank_slip = \App\Models\STD\BankSlip::create([
            'student_id' => $student_id,
            'receipt_number' => $receipt_number,
            'student_name' => $student_name,
            'reg_code' => $student_reg_code
        ]);

        \App\Models\STD\BankSlipDetail::create([
            'bank_slip_id' => $bank_slip->id,
            'fee_type' => $purpose_info['name'],
            'fee_amount' => $total_payable
        ]);

        $data = [
            'receipt_number' => $receipt_number,
            'bank_slip_id' => $bank_slip->id
        ];

        return $data;
    }

    public function otherFormVerification($key)
    {

        $array = explode('-', $key);
        $otherStudentForm = OtherStudentForm::select('id', 'form_name', 'name', 'created_by', 'reg_code', 'shift', 'receipt_no')
            ->where([
                'id' => $array[1],
                'code' => $array[0]
            ])->first();

        if (!$otherStudentForm) {
            return response()->json(['message' => 'no data found'], 404);
        }

        return $otherStudentForm;
    }

    public function otherFormVerificationStatusChange(Request $request)
    {
        $this->validate($request, [
            'form_number' => 'required|integer',
            'status' => 'required|in:received,prepared,compared,verified,seen,approved',
            'verify_status' => 'required|in:1,2',
        ]);

        $otherStudentForm = OtherStudentForm::find($request->form_number);

        if (!$otherStudentForm) {
            return response()->json(['message' => 'no data found'], 404);
        }

        $statusMessage = 'pass';

        if ($request->verify_status == 2) {
            $statusMessage = 'approved';
        }

        OtherStudentFormStatus::create([
            'other_student_form_id' => $request->form_number,
            'employee_id' => $request->auth->id,
            'verified_status' => $request->verify_status,
            'type' => trim($request->status),
        ]);

        return response()->json(['message' => $request->status . ' ' . $statusMessage . ' ' . 'successfully'], 201);
    }

    public function index()
    {
        return OtherStudentForm::with('docmtg')->where('form_name', '!=', 'Transcript / Mark Certificate')->get();
    }

    public function transcript()
    {
        return OtherStudentForm::where('form_name', 'Transcript / Mark Certificate')->get();
    }

    public function transcriptFilter(Request $request)
    {
        return OtherStudentForm::where('form_name', 'Transcript / Mark Certificate')
            ->where('name', $request->student_name)
            ->get();
    }

    public function finalApplicationFormDownload(Request $request, $id)
    {

        $otherStudentForm = OtherStudentForm::find($id);

        $student = $this->studentInfoWithCompleteSemesterResult($otherStudentForm->student_id);
        $student = $student['student'];

        $batch_sup = $this->sup($student['batch']['batch_name']);

        $student_provisional_transcript_marksheet_info_by_student_id = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);
        $passingYear = 'N/A';
        $year = 'N/A';

        if ($student_provisional_transcript_marksheet_info_by_student_id['result_publish_date_of_last_semester']) {
            $passingYear = \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info_by_student_id['result_publish_date_of_last_semester']))->format('Y');
            $year = number_format(($student_provisional_transcript_marksheet_info_by_student_id['duration_in_month'] / 12), 2);
        }

        $pronouns = 'She';
        $pronouns_s = 'she';
        $pronouns_p = 'her';
        $pronouns_pp = 'her';
        $pronouns_ppp = 'Her';

        if ($student['gender'] == 'M') {
            $pronouns = 'He';
            $pronouns_s = 'he';
            $pronouns_p = 'him';
            $pronouns_pp = 'his';
            $pronouns_ppp = 'His';
        }

        $view = '';
        if ($otherStudentForm->form_name == 'Testimonial') {

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, son of {$student['f_name']} and {$student['m_name']} was a student of the Department of {$student['department']['name']} bearing Roll No. {$student['roll_no']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup>, Registration No. {$student['reg_code']} under Session {$student['session_name']} at Dhaka International University (DIU). {$pronouns} has successfully completed {$year} years <b>{$student['department']['name']}</b> in the year {$passingYear} and earned CGPA <b>{$student['cgpa']}</b> in a scale of 4.00 with the Average Grade {$student['grade_letter']}. <br> <br> {$pronouns} is a good student and to the best of my knowledge {$pronouns_s} bears a good moral character. <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'Testimonial';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }

        if ($otherStudentForm->form_name == 'Character Certificate') {

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, son of {$student['f_name']} and {$student['m_name']} was a student of the Department of {$student['department']['name']} bearing Roll No. {$student['roll_no']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup> Registration No. {$student['reg_code']} under Session {$student['session_name']} at Dhaka International University (DIU). {$pronouns} has successfully completed all the courses of {$year} years <b>{$student['department']['name']}</b> Program in the year {$passingYear} and earned CGPA <b>{$student['cgpa']}</b> in a scale of 4.00 with the Average Grade {$student['grade_letter']}. <br> <br> To the best of my knowledge {$pronouns_s} bears a good moral character and {$pronouns_s} did not take part in any activity subversive either of the state or of discipline during {$pronouns_pp} study in this University. <br> <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'Character Certificate';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }

        if ($otherStudentForm->form_name == 'Medium of Instruction Certificate') {

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, son of {$student['f_name']} and {$student['m_name']} was a student of the Department of {$student['department']['name']} bearing Roll No. {$student['roll_no']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup> Registration No. {$student['reg_code']} under Session {$student['session_name']} at Dhaka International University (DIU). {$pronouns} has successfully completed all the courses of {$year} years <b>{$student['department']['name']}</b> Program in the year {$passingYear} and earned CGPA <b>{$student['cgpa']}</b> in a scale of 4.00. <br> <br> The medium of instruction and examination in this University is English. {$pronouns} will be able to conduct research or higher studies in English.<br> <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'Medium of Instruction Certificate';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }

        if ($otherStudentForm->form_name == 'Migration Certificate') {

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, son of {$student['f_name']} and {$student['m_name']} was a student of the Department of {$student['department']['name']} bearing Roll No. {$student['roll_no']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup>, Registration No. {$student['reg_code']} under Session {$student['session_name']} at Dhaka International University (DIU). {$pronouns} has successfully completed all the courses {$year} years <b>{$student['department']['name']}</b> in the year {$passingYear} and earned Cumulative Grade Point Average (CGPA) <b>{$student['cgpa']}</b> in a scale of 4.00. <br> <br> To the best of my knowledge {$pronouns_s} bears a good moral character and {$pronouns_s} did not take part in any activity subversive either of the state or of discipline during {$pronouns_pp} study in this University. <br> <br> We have no objection as to his migration elsewhere in pursuance of higher studies. <br> <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'Migration Certificate';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }

        if ($otherStudentForm->form_name == 'Studentship Certificate') {

            $semester_sup = $this->sup($student['current_semester']);

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, son of {$student['f_name']} and {$student['m_name']} is a student of {$student['department']['name']} Program duration {$year} years bearing Roll No. {$student['roll_no']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup>, Registration No. {$student['reg_code']} under Session {$student['session_name']} at Dhaka International University (DIU). Now {$pronouns_s} is in {$student['current_semester']} <sup>{$semester_sup}</sup> Semester. <br> <br>{$pronouns} is a good student and to the best of my knowledge {$pronouns_s} bears a good moral character.<br> <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'Studentship Certificate';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }

        if ($otherStudentForm->form_name == 'Appeared Certificate') {

            $semester_sup = $this->sup($student['current_semester']);
            $upcoming_semester = $student['current_semester'] + 1;
            $upcoming_semester_sup = $this->sup($upcoming_semester);

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, Son of {$student['f_name']} and {$student['m_name']} is a student of {$student['department']['name']} Program, duration {$year} bearing Roll No. {$student['roll_no']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup>, Registration No. {$student['reg_code']}, session {$student['session_name']} at Dhaka International University (DIU). {$pronouns} has successfully completed up to {$student['current_semester']} <sup>{$semester_sup}</sup> Semester courses and appeared in the {$upcoming_semester}{$upcoming_semester_sup} Semester Final Examination the result of which is yet to be published. <br> <br>{$pronouns} is a good student and to the best of my knowledge {$pronouns_s} bears a good moral character.<br> <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'Appeared Certificate';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }

        if ($otherStudentForm->form_name == 'English Proficiency Certificate') {

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, son of {$student['f_name']} and {$student['m_name']} was a studunt of the Department of {$student['department']['name']} bearing Roll No. {$student['roll_no']}, Registration No. {$student['reg_code']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup> under Session {$student['session_name']} at Dhaka International University (DIU). {$pronouns} has successfully completed {$year} years Bachelor of <b>{$student['department']['name']}</b> in the year {$passingYear} and obtained a Cumulative Grade Point Average of <b>{$student['cgpa']}</b> in the scale of 4.00.<br><br> {$pronouns_ppp} medium of instruction and examination in this University was English. {$pronouns} will be able to conduct research or higher studies in English.<br> <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'English Proficiency Certificate';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }

        if ($otherStudentForm->form_name == 'Course Completion Certificate') {

            $details = "This is to certify that <b> {$otherStudentForm->name} </b>, son of {$student['f_name']} and {$student['m_name']} is a student of the Department of {$student['department']['name']} Program, duration {$year} years bearing Roll No. {$student['roll_no']}, Registration No. {$student['reg_code']}, Batch No. {$student['batch']['batch_name']}<sup>{$batch_sup}</sup> under Session {$student['session_name']} at Dhaka International University (DIU), Banani, Dhaka-1213. {$pronouns} has successfully completed all Semester. {$pronouns} has applied for {$pronouns_pp} Certificate which is under process. <br><br>{$pronouns} is a good student and bears a good moral character.<br> <br> <br> I wish {$pronouns_p} every success in life.";
            $referenceCreate = $this->referenceCreate($otherStudentForm->form_name, $otherStudentForm->id, $details, $request->auth->id);
            $title = 'Course Completion Certificate	';

            $view = view('otherDownloadForm/application/application', compact('details', 'referenceCreate', 'title'));
        }


        if (empty($view)) {
            return response()->json(['error' => 'Application not found'], 403);
        }

        $otherStudentForm->reference_no = $referenceCreate->doc_mtg_code;
        $otherStudentForm->download_by = $request->auth->id;
        $otherStudentForm->save();

        return $this->mpdf_show($view);
    }

    public function referenceCreate($title, $form_number, $details, $auth_user)
    {
        $signatory = 'Prof. Md. Rofiqul Islam, Registrar (Dhaka International University)';
        $current_date = Carbon::now()->format('Y-m-d');
        $doc_type = 'public';
        $category = '5 years';

        $doc = $this->create_doc(
            $title,
            $title,
            $form_number,
            $signatory,
            $details,
            $auth_user,
            $current_date,
            $doc_type,
            $category
        );

        $id = $doc->id;

        $code = $id . '/REG/DIU/' . date('m') . '/' . date('Y');

        $doc->doc_mtg_code = $code;
        $doc->save();
        return $doc;
    }

    public function formNotUploaded()
    {
        return OtherStudentForm::whereNull('uploaded_by')->select('id', 'name', 'reg_code')->get();
    }

    public function formUploaded(Request $request, $id)
    {

        $this->validate($request, [
            'document_url' => 'required|mimes:pdf|max:1024',
        ]);

        $otherStudentForm = OtherStudentForm::find($id);

        $docmtg = Docmtg::where('doc_mtg_code', $otherStudentForm->reference_no)->first();

        $image = $request->file('document_url');
        $extention = strtolower($image->getClientOriginalExtension());
        $filename = 'doc' . $docmtg->id . '.' . $extention;
        $request->file('document_url')->move(storage_path('docs'), $filename);

        $docmtg->extension = $extention;
        $docmtg->save();


        $otherStudentForm->uploaded_by = $request->auth->id;
        $otherStudentForm->save();


        //        $otherStudentForm->otp = trim($otherStudentForm->id . '-' . rand(100000, 999999));

        $message = "Dear {$otherStudentForm->name}.Your OTP is {$otherStudentForm->otp}";
        //        $this->send_sms($otherStudentForm->mobile_no, $message);

        return response()->json(['message' => 'Uploaded Successfully'], 201);
    }

    //transcript
    public function transcriptApplicationFormDownload(Request $request, $id)
    {
        $this->validate($request, [
            'form_id' => 'required|integer',
            'issue_no' => 'required',
            'date' => ['required', 'date', new CheckValidDate],
            'result_published_date' => ['required', 'date', new CheckValidDate],
        ]);


        try {

            $otherStudentForm = OtherStudentForm::find($request->form_id);
            $otherStudentForm->issue_no = $request->issue_no;
            $otherStudentForm->date = \Carbon\Carbon::parse($request->date)->format('Y-m-d');
            $otherStudentForm->result_published_date = \Carbon\Carbon::parse($request->result_published_date)->format('Y-m-d');


            $transcript = $this->provisional_result($otherStudentForm->student_id);
            $student_provisional_transcript_marksheet_info = $this->student_provisional_transcript_marksheet_info_by_student_id($otherStudentForm->student_id);

            $student_info = $transcript['student_info'];
            $grade_point_system_details = $transcript['grade_point_system_details'];
            $transcript_data = $transcript['transcript_data'];
            $token = md5($id);

            $transcript_result = $transcript_data['results'];
            $transcript_data = array_reduce($transcript_data['semesters'], 'array_merge', array());

            if (!$otherStudentForm->pdfFileName($student_info)) {
                return response()->json(['error' => 'Transcript not found'], 406);
            }

            $otherStudentForm->download_by = $request->auth->id;
            $otherStudentForm->save();


            $views_name = 'otherDownloadForm/application/' . $otherStudentForm->pdfFileName($student_info);
            $view = view($views_name, compact('student_info', 'grade_point_system_details', 'transcript_data', 'transcript_result', 'student_provisional_transcript_marksheet_info', 'otherStudentForm'));

            $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
            return $this->mpdf_show($view);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['message' => $exception->getMessage()]);
        }
    }

    public function transcriptFormUpload(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'document_url' => 'required|mimes:pdf|max:1024',
            ]
        );

        $otherForm = OtherStudentForm::find($id);

        if (!$otherForm) {
            return response()->json(['error' => 'No data found'], 404);
        }


        $student = $this->studentInfoWithCompleteSemesterResult($otherForm->student_id);


        $batchName = $student['student']['batch']['batch_name'] . $this->sup($student['student']['batch']['batch_name']);

        $regcode_exists = Transcript::where('regcode', trim($otherForm->reg_code))->exists();

        if ($regcode_exists) {
            return response()->json(['error' => 'Transcript reg code already exists'], 400);
        }


        try {
            \DB::beginTransaction();

            if ($request->hasFile('document_url') && $request->file('document_url')->isValid()) {
                $file = $request->file('document_url');
                $extention = strtolower($file->getClientOriginalExtension());
                $fileName = '' . trim($otherForm->reg_code) . '-' . $otherForm->roll . '.' . $extention;
                $request->file('document_url')->move(storage_path('transcripts'), 'transcripts/' . $fileName);
            }

            Transcript::create([
                'transcript_department_id' => $otherForm->department_id,
                'name' => $otherForm->name,
                'regcode' => trim($otherForm->reg_code),
                'cgpa' => $otherForm->cgpa,
                'roll' => $otherForm->roll,
                'session' => $otherForm->session,
                'passing_year' => $otherForm->passing_year,
                'created_at' => time(),
                'created_by' => $request->auth->id,
                'filename' => $fileName,
                'has_file' => 1,
                'shift' => $otherForm->studentShiftName(),
                'batch' => $batchName,
            ]);

            $otherForm->uploaded_by = $request->auth->id;
            $otherForm->save();

            \DB::commit();
            return response()->json(['success' => 'Transcript upload Successful.'], 201);
        } catch (\PDOException $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Transcript upload Failed.'], 400);
        }
    }
}
