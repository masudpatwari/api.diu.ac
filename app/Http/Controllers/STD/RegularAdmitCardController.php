<?php

namespace App\Http\Controllers\STD;

use App\Traits\MetronetSmsTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Employee;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;

class RegularAdmitCardController extends Controller
{
    use RmsApiTraits;
    use MetronetSmsTraits;

    public function getPurposePay()
    {
        return $result = $this->get_purpose_pay();
    }

   

    public function download_regular_admit_card($ora_uid, $term)
    {
        $url = env('RMS_API_URL') . '/download_regular_admit_card';
        $array = [
            'ora_uid' => $ora_uid,
        ];

        $result = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/student_account_info_summary/' . $ora_uid . '', false, self::ssl()));

        if ($term == 'final' && $result->summary->total_current_due > 501) {

            return response()->json(['error' => 'Please clear current due amount'], 401);
        }

        //     return [$result->summary->per_semester_fee_without_scholarship];

        if ($term == 'mid' && $result->summary->total_current_due > 501+($result->summary->per_semester_fee_without_scholarship/2)) {

            return response()->json(['error' => 'Please clear current due amount'], 401);
        }
        

        $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

        $data = "";
        if ($response->status == 200) {
            $data = $response->content;
        } else {
            return response()->json(['error' => $response->content['error']], 400);
        }

        $student_id = $data['id'];
        $token = md5($student_id);

        $file_path = storage_path('admit_cards/regular_admit_card_' . $student_id . '.pdf');
        if($term == 'mid')
        {
            $view = view('admit_cards/regular_mid_admit_card', $data);
        }else{
            $view = view('admit_cards/regular_admit_card', $data);
        }
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->SetTitle('regular_admit_card' . $token . '');
        $mpdf->WriteHTML(file_get_contents(storage_path('assets/improvement_admit_card.css')), 1);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view, 2);
        $mpdf->Output($file_path, 'F');
        return $mpdf->Output('regular_admit_card' . $token . '', 'I');
    }

    public function get_spcial_admit_card($ora_uid)
    {
        $url = env('RMS_API_URL') . '/download_regular_admit_card';
        $array = [
            'ora_uid' => $ora_uid,
        ];
        $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

        $data = "";
        if ($response->status == 200) {
            return $response->content;
        } else {
            return response()->json(['error' => $response->content['error']], 400);
        }
    }

    public function download_spcial_admit_card($ora_uid, $remove_ids = null)
    {
        $url = env('RMS_API_URL') . '/download_regular_admit_card';
        $array = [
            'ora_uid' => $ora_uid,
        ];
        $response = Curl::to($url)->withData($array)->returnResponseObject()->asJsonResponse(true)->post();

        $data = "";
        if ($response->status == 200) {
            $data = $response->content;

            if (!empty($remove_ids)) {
                foreach ($data['allocated_course'] as $key => $value) {
                    if (array_key_exists($value['id'], array_flip(explode("-", $remove_ids)))) {
                        unset($data['allocated_course'][$key]);
                    }
                }
            }

        } else {
            return response()->json(['error' => $response->content['error']], 400);
        }

        $student_id = $data['id'];
        $token = md5($student_id);


        $file_path = storage_path('admit_cards/spcial_admit_card_' . $student_id . '.pdf');
        $view = view('admit_cards/regular_admit_card', $data);
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
        $mpdf->SetTitle('spcial_admit_card' . $token . '');
        $mpdf->WriteHTML(file_get_contents(storage_path('assets/improvement_admit_card.css')), 1);
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->WriteHTML($view, 2);
        $mpdf->Output($file_path, 'F');
        return $mpdf->Output('spcial_admit_card' . $token . '', 'I');
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
}
