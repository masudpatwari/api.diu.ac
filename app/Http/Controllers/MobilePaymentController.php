<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mobilepayment;
use Illuminate\Support\Facades\DB;
use App\Traits\RmsApiTraits;
use Ixudra\Curl\Facades\Curl;

class MobilePaymentController extends Controller
{
    use RmsApiTraits;

    public function index()
    {

        return response()->json(Mobilepayment::getData(), 200);
    }

    public function verified()
    {
        return response()->json(Mobilepayment::getData(true), 200);
    }

    public function manualInput(Request $request)
    {

    }

    public function mobilePaymentCSVFileUpload(Request $request)
    {
        $this->validate($request,
            [
                'accountType' => 'required|in:bkash,rocket,nogod',
                'actual_file' => 'required|mimes:csv,txt'
            ]
        );

        try {
            $file = $request->file('actual_file');
            $accountType = $request->accountType;

            $destinationFile = storage_path('/mobile_banking_files/');

            if (file_exists($destinationFile . '/' . $accountType . '_' . $file->getClientOriginalName())) {
                unlink($destinationFile . '/' . $accountType . '_' . $file->getClientOriginalName());
                //throw new \Exception('File Already Exists!');
            }
            $file->move($destinationFile, $accountType . '_' . $file->getClientOriginalName());


            if (!is_readable($destinationFile . '/' . $accountType . '_' . $file->getClientOriginalName())) {
                throw new \Exception("File is not readable", 1);
            }

            $filename = $destinationFile . '/' . $accountType . '_' . $file->getClientOriginalName();
            $data = array();
            $delimiter = ',';
            $filecontent = file_get_contents($filename);
            $lines = explode("\n", $filecontent);

            $mobilepayment = [];

            $i = 0;

            foreach ($lines as $line) {
                if ($i == 0) {
                    $i++;
                    continue;
                }
                /*
                0   "Serial No."
                1   "Date & Time"
                2   "Transaction Type"
                3   "From Account Number"
                4   "To Account Number"
                5   "Transaction Amount"
                6   "Coupon Amount"
                7   "Total Transaction Amount"
                8   "Coupon Status"
                9   "Transaction ID"
                10  "Transaction Reference\r"
                */

                $fields = explode(",", $line);

                if (!isset($fields[1])) {
                    continue;
                }

                $datatime = $fields[1];
                $fromAccountNumber = $fields[3];
                $totalTransactionAmount = $fields[7];
                $transactionId = $fields[9];
                $reference = str_replace("\r", '', $fields[10]);

                $mobilepayment[$i]['regcode'] = $reference;
                $mobilepayment[$i]['payment_type'] = 'NA for Batch Input';
                $mobilepayment[$i]['payment_method'] = $accountType;
                $mobilepayment[$i]['amount'] = $totalTransactionAmount;
                $mobilepayment[$i]['datetime'] = $datatime;
                $mobilepayment[$i]['response'] = 'NA for Batch Input';
                $mobilepayment[$i]['from'] = ' Batch Input file';
                $mobilepayment[$i]['filedetail'] = $filename;
                $mobilepayment[$i]['rowdetail'] = $line;

                $i++;
            }

            DB::beginTransaction();

            Mobilepayment::insert($mobilepayment);

            DB::commit();

            return response()->json(['message' => "Import Successfully completed!"], 200);

        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], 400);
        }
    }

    public function verifyPayment(Request $request, $id)
    {
        return response()->json(['error' => 'Update Failed.'], 400);
    }


    public function covidAccountsReport($batchId)
    {
        return $this->rmsCovidAccountsReport($batchId);
    }




    public function eligibleStudentsForExam($batchId)
    {
        $students = $this->rmsCovidAccountsReport($batchId);

        $studentsData = [];
        foreach ($students as $key => $student) {
            $studentsData[$key] = $student;
        }

        $eligibleStudents = [];
        foreach ($studentsData['original'] as $row) {
            if ($row->summary->total_current_due < 501) {
                $eligibleStudents[] = [
                    'id' => $row->id,
                    'name' => $row->name,
                    'roll_no' => $row->roll_no,
                    'reg_code' => $row->reg_code,
                    'total_current_due' => $row->summary->total_current_due,
                ];
            }
        }

        $url = env('RMS_API_URL') . '/get_student_by_id/' . $eligibleStudents[0]['id'];
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        $department_name = '';
        $department_short_code = '';
        $current_semester = '';
        $batch_name = '';

        if ($response->status == 200) {
            $department_name =  $response->content['department']['name'] ?? '';
            $department_short_code =  $response->content['department']['short_code'] ?? '';
            $current_semester =  $response->content['current_semester'] ?? '';
            $batch_name =  $response->content['batch']['batch_name'] ?? '';
        }

        $view = view('eligibleStudentsForExam', compact('eligibleStudents','department_name','department_short_code','batch_name','current_semester'));
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view);
        return $mpdf->Output('eligible-students-for-exam', 'I');

    }
}
