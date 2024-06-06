<?php

namespace App\Http\Controllers;

use App\ApiKey;
use App\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use App\Traits\RmsApiTraits;



class ExamController extends Controller
{
    use RmsApiTraits;

    public function sessionUpdate(Request $request)
    {
        return $this->exam_controller_session_update($request->all());
    }
    public function convocationList($batch_id)
    {
        $result =  $this->get_convocation_list__students($batch_id);
        if(!empty($result)){
            return $result;
        }else{
            return response()->json(['message' => 'Not found'], 404);
        }
    }
    public function convocationListPdf($batch_id)
    {
        $students = $this->get_convocation_list__students($batch_id);

        $department =  $students['data'][0]['department'] ?? 'NA';
        $batch =  $students['data'][0]['batch'] ?? 'NA';
        $session =  $students['data'][0]['session'] ?? 'NA';


        $view = view('controller/convocation-list-pdf', compact('students'))->render();
        $header = view('controller/convocation-list-header', compact('department', 'batch', 'session'))->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path('temp'),
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 35,
            'margin_bottom' => 10,
        ]);
        // Set the same header for the first page and subsequent pages
        $mpdf->SetHTMLHeader($header, 'O'); // Header for Odd pages
        $mpdf->SetHTMLHeader($header, 'E'); // Header for Even pages
        $mpdf->WriteHTML($view);
        return $mpdf->Output('admission Register', 'I');
    }
}
