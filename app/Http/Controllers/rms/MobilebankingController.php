<?php

namespace App\Http\Controllers\rms;

use App\Traits\MetronetSmsTraits;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use App\Models\RMS\WpEmpRms;
use App\Employee;
use App\Mobilepayment;
use App\Http\Controllers\Controller;
use App\Http\Resources\rms\WpEmpRmsResource;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;

class MobilebankingController extends Controller
{
    use RmsApiTraits;
    use MetronetSmsTraits;

    public function getStudentByRegcodePartial($txid, $regcodepart = NULL)
    {

        $url = env('RMS_API_URL') . "/get-student-by-regcode-part/" . $txid . '/' . $regcodepart;

        $response = Curl::to($url)
//            ->withData($course_array)
            ->returnResponseObject()
            ->asJson(true)
            ->get();
//        dd($response);
        if ($response->status == 200)
            return response()->json($response->content, $response->status);

        return response()->json($response->content['message'], $response->status

        );

    }

    public function getStudentByRegcodePartialForManualInput($regcodepart = NULL)
    {

        $url = env('RMS_API_URL') . "/get-student-by-regcode-part-for-manual-input/" . $regcodepart;

        $response = Curl::to($url)
//            ->withData($course_array)
            ->returnResponseObject()
            ->asJson(true)
            ->get();
//        dd($response);
        if ($response->status == 200)
            return response()->json($response->content, $response->status);

        return response()->json($response->content['message'], $response->status

        );

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'purpose_pay' => 'required|integer',
            'payment_method' => 'required',
            'amount' => 'required',
            'transection_id' => 'required',
            'bankdate' => 'required',
            'fromMobileNumber' => 'required',
        ]);

        $reqArray = $request->all();


        unset($reqArray['token']);
        unset($reqArray['reference']);

        $reqArray['office_email'] = Employee::find($request->auth->id)->office_email;

        $url = env('RMS_API_URL') . '/mobile-banking/manual-entry';

        $response = Curl::to($url)->withData($reqArray)->returnResponseObject()->asJson(true)->post();

        $this->sendStudentSmsForFeeManualCollection($request->purpose_pay,$request->id,$request->amount);

        return response()->json($response->content, $response->status);
    }

    public function verifyPayment(Request $request, $stdId, $mobileBaningRowId)
    {
        $row = Mobilepayment::find($mobileBaningRowId);

        /*
     all: [
       "SPECIAL DEFENSE / VIVA  FEE" => 19,
       "INTERNSHIP, PROJECT OR RESEARCH MONOGRAPH FEE" => 20,
       "IN-COURSE IMMPROVEMNET FEE" => 21,
       "FINAL TRANSCRIPT FEE" => 22,
       "ADVANCE ENGLISH FEE" => 23,
       "MID-TERM RE-TAKE" => 24,
       "NORMAL TRANSCRIPT FEE" => 18,
       "OTHERS" => 1,
       "SCHOLARSHIP" => 2,
       "REGISTRATION FEE" => 3,
       "ADMISSION FEE" => 4,
       "TUITION FEE" => 5,
       "EXAMINATION FEE" => 6,
       "FINAL IMPROVEMENT FEE" => 7,
       "MARKS SHEET FEE" => 8,
       "PROVISIONAL CERTIFICATE FEE" => 9,
       "LIBRARY FEE" => 10,
       "FINE/LATE FEE" => 11,
       "CONVOCATION FEE" => 12,
       "ID CARD FEE" => 13,
       "RE ADMISSION FEE" => 14,
       "SESSION FEE" => 15,
       "STUDY TOUR FEE" => 16,
       "DEVELOPMENT FEE" => 17,
     ],
        */
        $purpose_pay_id_array = [
            'registration-fee' => 3,
            'admission-fee' => 4,
            'tuition-fee' => 5,
            'final-improvement-fee' => 7,
            'in-course-immprovemnet-fee' => 21,

            // "marks-sheet-fee" => 8, = 22 + 18

            "final-transcript-fee" => 22,
            "normal-transcript-fee" => 18,

            'examination-fee' => 6,
            "internship-project-or-research-monograph-fee" => 20,
            "advance-english-fee" => 23,
            "mid-term-re-take" => 24,
            "special-defense-viva-fee" => 19,
            "provisional-certificate-fee" => 9,
            "library-fee" => 10,
            "fine-late-fee" => 11,
            "convocation-fee" => 12,
            "id-card-fee" => 13,
            "re-admission-fee" => 14,

            "session-fee" => 15,
            "study-tour-fee" => 16,
            "development-fee" => 17,

            "others" => 1,
        ];

        $purpose_pay_id = '5';

        if ($row->payment_type == 'final-improvement-fee' || $row->payment_type == 'in-course-immprovemnet-fee') {
            return response()->json('Final/Incourse Improvement verify denied!', 400);
        }
        if (array_key_exists($row->payment_type, $purpose_pay_id_array)) {
            $purpose_pay_id = $purpose_pay_id_array[$row->payment_type];
        }


        $actualAmountAfterSubtractCommittion = 0;
        $transectionId = '';
        switch ($row->payment_method) {
            case 'bkash':
                $commistionPercentage = 1.5;
                $actualAmountAfterSubtractCommittion = $row->amount - ceil(($commistionPercentage / 100) * $row->amount);
                $transectionId = explode(',', $row->rowdetail)[9];// 9 = trxId
                break;
            case 'nagad': // pay from payment site
                $commistionPercentage = 1;
                $actualAmountAfterSubtractCommittion = $row->amount - ceil(($commistionPercentage / 100) * $row->amount);
                $transectionId = explode(',', $row->rowdetail)[3]; // 3 = diu invoice id
                break;
            case 'nogod': // batch input
                $commistionPercentage = 1;
                $actualAmountAfterSubtractCommittion = $row->amount - ceil(($commistionPercentage / 100) * $row->amount);
                $transectionId = explode(',', $row->rowdetail)[9]; // 9 = issuer ref no
                break;
            case 'rocket':
                $actualAmountAfterSubtractCommittion = $row->amount;
                $transectionId = explode(',', $row->rowdetail)[9]; // 9 = trxId
                break;
            default:
                return response()->json("Payment Method" . $row->payment_method . " Not valid.", 400);
                break;
        }

        $dataArray = [
            'id' => $stdId,
            'purpose_pay' => $purpose_pay_id,
            'payment_method' => $row->payment_method,
            'payment_type' => $row->payment_type,
            'amount' => $actualAmountAfterSubtractCommittion,
            'transection_id' => $transectionId,
            'bankdate' => $row->datetime,
            'fromMobileNumber' => explode(',', $row->rowdetail)[3],
            'from' => $row->from,
        ];

        $dataArray['office_email'] = Employee::find($request->auth->id)->office_email;

        $url = env('RMS_API_URL') . '/mobile-banking/import-mobile-banking-transaction';

        $response = Curl::to($url)->withData($dataArray)->returnResponseObject()->asJson(true)->post();

        if ($response->status == 200) {
            $row->isverified = 1;
            $row->save();
            //sms send
            $this->sendStudentSmsForFeeCollection($row->payment_type, $stdId, $row->amount);
        }

        return response()->json($response->content, $response->status);
    }

    public function deleteMobilepayment($mobileBaningRowId)
    {
        try {
            Mobilepayment::deleteMobilepayment($mobileBaningRowId);
            return response()->json(['message' => 'deleted'], 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'delete fail'], 400);
        }
    }


    public function sendStudentSmsForFeeCollection($purpose, $student_id, $total_payable)
    {
        $student = $this->traits_get_student_by_id($student_id);

        $message = "Dear {$student->name} Received TK. {$total_payable}/- as {$purpose} DIU";
        $this->send_sms($student->phone_no, $message);
    }

    public function sendStudentSmsForFeeManualCollection($purpose_id, $student_id, $total_payable)
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

}
