<?php

namespace App\Http\Controllers\adsn;

use App\ApiKey;
use App\Employee;
use App\Models\adsn\EnglishBookFormDetails;
use App\Models\adsn\FormDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;


class AdmisisonFormController extends Controller
{
    
    public function search(Request $request, $form)
    {
        $form_details = FormDetails::where('form_number', $form)
                    ->whereNull('name_of_student')
                    ->whereNull('dept_id')
                    ->whereNull('batch_id')
                    ->first();

        if(empty($form_details))
        {
           return response('Form Not Available', 302);
        }

        return $form_details;
    }

    public function english_book_search(Request $request, $form)
    {
        $form_details = EnglishBookFormDetails::where('form_number', $form)
                    ->whereNull('name_of_student')
                    ->whereNull('dept_id')
                    ->whereNull('batch_id')
                    ->first();

        if(empty($form_details))
        {
           return response('Form Not Available', 302);
        }

        return $form_details;
    }


    public function update(Request $request, $id){

        $this->validate($request, [
            'std_name' => ['required','string'],
            'dept_id' => ['required','numeric'],
            'batch_id' => ['required','numeric'],
        ]
    );
    
       
        $form =  FormDetails::where('form_number', $id)
            ->whereNull('name_of_student')
            ->whereNull('dept_id')
            ->whereNull('batch_id')
            ->first();

        if(!$form)
         {
             return response(['error' => 'From sold just now'], 406);
         }

        $api_user = ApiKey::where('apiKey', $request->token)->first();

        try {

            $form->update([
                "name_of_student" => $request->std_name,
                "dept_id" => $request->dept_id,
                "batch_id" => $request->batch_id,
                "saler_id" => $request->auth->id ?? $api_user->employee_id,
                'sale_date' => Carbon::now()->format('Y-m-d')
            ]);

            $receipt_no = 'FS'.$id;

            return response(['success' => 'Form Sold Successfully', 'receipt_no' => $receipt_no], 200);

        }catch (\Exception $exception)
        {
            return response(['error' => $exception->getMessage()], 400);
        }
    }

    public function english_book_update(Request $request, $id){

        $this->validate($request, [
            'std_name' => ['required','string'],
            'dept_id' => ['required','numeric'],
            'batch_id' => ['required','numeric'],
        ]
    );


        $form =  EnglishBookFormDetails::where('form_number', $id)
            ->whereNull('name_of_student')
            ->whereNull('dept_id')
            ->whereNull('batch_id')
            ->first();

        if(!$form)
         {
             return response(['error' => 'From sold just now'], 406);
         }

        $api_user = ApiKey::where('apiKey', $request->token)->first();

        try {

            $form->update([
                "name_of_student" => $request->std_name,
                "dept_id" => $request->dept_id,
                "batch_id" => $request->batch_id,
                "saler_id" => $request->auth->id ?? $api_user->employee_id,
                'sale_date' => Carbon::now()->format('Y-m-d')
            ]);

            $receipt_no = 'BS'.$id;

            return response(['success' => 'Form Sold Successfully', 'receipt_no' => $receipt_no], 200);

        }catch (\Exception $exception)
        {
            return response(['error' => $exception->getMessage()], 400);
        }
    }


    public function getBatch($id){

        $batches = Curl::to(env('RMS_API_URL').'/batches-in-department/'.$id)
            ->asJsonResponse(true)
            ->get();

        $all_batches = collect($batches)->map(function($item){
           return [
               'id' => $item['id'],
               'name' => $item['batch_name']
           ];
        });

        return $all_batches;

    }

    public function getPrintRecieve($recieve){

        $payable = 1000;
        $recieve_id = $recieve;
        $form_no = substr($recieve, 2);
        $form_info = FormDetails::where('form_number', $form_no)->first();
        // dd($form_info);

        $department_info =  Curl::to(env('RMS_API_URL').'/get_deptartment/'.$form_info->dept_id)
            ->asJsonResponse(true)
            ->get();


        $batch_info =  Curl::to(env('RMS_API_URL').'/admission/batch/'.$form_info->batch_id)
            ->asJsonResponse(true)
            ->get();           
     
        $saler= Employee::with('relDesignation')->find($form_info->saler_id);
    // return  $saler['relDesignation'];

        $student = $form_info;
        $student['department_name'] = $department_info['name'];
        $student['batch_name'] = $batch_info['data']['batch_name'];
        $purpose = 'ADMISSION FORM';
        

        $bank_info['account_no'] = '6113100002042';

        $view = view('otherDownloadForm/admission_slip', compact('student',  'recieve_id', 'purpose', 'payable', 'bank_info','saler'));
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
        $mpdf->WriteHTML($view);
        return $mpdf->Output('payment_slip', 'I');

    }

    public function getPrintRecieveEnglishBook($recieve){

        $payable = 500;
        $recieve_id = $recieve;
        $form_no = substr($recieve, 2);
        $form_info = EnglishBookFormDetails::where('form_number', $form_no)->first();
        // dd($form_info);

        $department_info =  Curl::to(env('RMS_API_URL').'/get_deptartment/'.$form_info->dept_id)
            ->asJsonResponse(true)
            ->get();


        $batch_info =  Curl::to(env('RMS_API_URL').'/admission/batch/'.$form_info->batch_id)
            ->asJsonResponse(true)
            ->get();

        $saler= Employee::with('relDesignation')->find($form_info->saler_id);
    // return  $saler['relDesignation'];

        $student = $form_info;
        $student['department_name'] = $department_info['name'];
        $student['batch_name'] = $batch_info['data']['batch_name'];
        $purpose = 'ENGLISH BOOK FROM';



        $bank_info['account_no'] = '6113100002042';

        $view = view('otherDownloadForm/english_book_slip', compact('student',  'recieve_id', 'purpose', 'payable', 'bank_info','saler'));
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
        $mpdf->WriteHTML($view);
        return $mpdf->Output('payment_slip', 'I');

    }

}
