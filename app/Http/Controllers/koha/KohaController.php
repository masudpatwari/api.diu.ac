<?php

namespace App\Http\Controllers\koha;


use App\Employee;
use App\LeaveApplication;
use App\Mail\EmployeeConfirmMail;
use App\Mail\StudentEmailVerify;
use App\Mail\TestMail;
use App\Models\GOIP\Goip;
use App\Models\STD\ApiKey;
use App\Models\STD\Batch;
use App\Models\STD\Student;
use App\Models\Tolet\BloodDonate;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\RMS\WpEmpRms;
use App\Models\STD\StaffsServiceCategory;
use App\Models\STD\StaffsServiceInfoFeedbacks;
use App\Models\STD\TeacherServiceCategory;
use App\Models\STD\TeacherServiceFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Encryption\Encrypter;

class KohaController extends Controller
{
    /*public function index()
    {

        $studentSupportTickets = \App\Models\STD\SupportTicket::with('support_ticket_department', 'support_ticket_department.supportTicketDepartmentRandomEmployees')
            ->whereNotNull('support_ticket_department_id')
            ->whereStatus('active')
            ->whereNull('assaign_to')
            ->get();


        dd($studentSupportTickets);

        foreach ($studentSupportTickets as $studentSupportTicket) {

            $studentSupportTicket->assaign_to = $studentSupportTicket->support_ticket_department->supportTicketDepartmentRandomEmployees->employee_id;
            $studentSupportTicket->assign_by = env('ROOT_EMPLOYEE_ID');
            $studentSupportTicket->assign_date_time = Carbon::now();
            $studentSupportTicket->save();

        }
//        dd($studentSupportTickets->support_ticket_department->supportTicketDepartmentRandomEmployees->employee_id);
//        return $studentSupportTickets->support_ticket_department->supportTicketDepartmentRandomEmployees->employee_id;
    }*/


    public static $url = 'https://pbx.diu.ac/goip/';


    public static function index()
    {
        $provider = '01839115794';
        $mobileNumberWith88Prefix = '8801521424060';

        // \Log::error([$provider, $mobileNumberWith88Prefix, $content]);
        // return;

        $url = static::$url . "sendsms/";

        $data = [
            'auth' => ['username'=>'api1', 'password'=>'api1'],
            'provider' => $provider,
            'number' => $mobileNumberWith88Prefix,
            'content' => 'test'
        ];

//         dd([$url,$data]);
//         \Log::error([$url,$data]);

        $response = Curl::to($url)
            ->withData($data)
             ->returnResponseObject()
            ->asJson(true)
            ->post();


        dd($response);
//        }catch (\Exception $exception)
//        {
//            return response($exception->getMessage());
//        }
    }

    public function sms()
    {
        return Student::with('relBatch:BATCH_NAME,ID')->first();

        return Batch::get();
        return Employee::groupBy('type')->pluck('type');
        return Goip::with('providers')->get();
        Goip::query()->update(['gsm_status' => 'ONLINE']);

        return 'OK';
        return
        file_get_contents_ssl('https://'.'api1'.':'.'api1'.'@pbx.diu.ac/goip/ussdinfo.php', false,
            stream_context_create([
            'http' => [
                'method' => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'content' => http_build_query([
                    'line2' => '1', 'smskey' => '57872222', 'action' => 'USSD', 'telnum' => '*111#', 'send' => 'Send'
                ])
            ]
        ]));
        return 'ok';
    }

    public function token(Request $request)
    {
        $token = $request->token;

        $lastAccessTimeObj = ApiKey::where('apiKey',$token)->withTrashed()->first();
        $explode_by = '.0.0.0.0.';
        $tokenArray = explode($explode_by, decrypt($token));

        return response()->json(['status' => 'success', 'data' => $tokenArray]);

    }

    public function encrypted(Request $request)
    {
        $email = $request->new_office_email;
        $pass = $request->password;

        $encrypted_mail = encrypt($email);
        // $encrypted_mail = Crypt::encryptString($email);

        return (decrypt($encrypted_mail));
    }

    public function mail_send(Request $request)
    {
        try {
            $explode_by = '.0.0.0.0.';

            $application_id = $leave->id;
            $timeout = strtotime(($leave->created_at)->addDays(7));
            $user_id = $leave->alt_employee;

            $info = implode($explode_by, [$application_id, $timeout, $user_id]);

            $token = encrypt($info);

            $application_created = $leave->created_at;

            $tokenArray = explode($explode_by, decrypt($token));
            $student_id = $tokenArray[0];
            $student_password = $tokenArray[1];
            $user = Student::find($student_id);

            return env('APP_URL').'confirm-mail/'.$employee->id;

//            return URL::signedRoute('confirm.mail', ['id' => $employee->id]);

            $mail = Mail::to($employee->private_email)->send(new EmployeeConfirmMail($employee));
        }catch (\Exception $exception)
        {
            return response($exception->getMessage());
        }
    }

    public function confirm_mail(Request $request, $id)
    {
        return $id;
//        try {
//            $employee = Employee::find(832);
//            $mail = Mail::to($employee->private_email)->send(new EmployeeConfirmMail($employee));
//        }catch (\Exception $exception)
//        {
//            return response($exception->getMessage());
//        }
    }

    public function ratingCategory(Request $request)
    {
        $type = 'faculty';
        $authId = $request->id;
//        $authId='362';

        $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();

        if ($employee) {
            return TeacherServiceCategory::whereStatus(1)->select([
                'id',
                'title',
                'english_title'
            ])->get();
        }

        return StaffsServiceCategory::whereStatus(1)->select([
            'id',
            'title',
            'english_title'
        ])->get();


    }


    public function ratingDetails(Request $request)
    {

        $type = 'faculty';

        $authId = $request->id;
        $categoryId = $request->category_id;
//        $authId='362';

        $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();

        if ($employee) {
            $wpEmpRms = WpEmpRms::whereEmail1($employee->office_email)->first();

            $teacherServiceFeedback = TeacherServiceFeedback::with('teacherServiceFeedbackDetails', 'teacherServiceFeedbackDetails.category')
                ->withCount([
                    'teacherServiceFeedbackDetails AS total' => function ($query) use ($categoryId) {
                        $query->select(\DB::raw("SUM(point)"))->where('teacher_service_category_id', $categoryId);
                    }
                ])->whereTeacherId($wpEmpRms->id)->get();

            return $teacherServiceFeedback->sum('total');

        }

        $collections = StaffsServiceInfoFeedbacks::with('staffServiceInfoFeedbackDetails', 'staffServiceInfoFeedbackDetails.category')->withCount([
            'staffServiceInfoFeedbackDetails AS total' => function ($query) use ($categoryId) {
                $query->select(\DB::raw("SUM(point)"))->where('staffs_service_category_id', $categoryId);
            }
        ])->whereEmployeeId($authId)->get();

        return $collections->sum('total');

    }

    public function api_sms()
    {
        $chatApiToken = "EAALXQC2uJj8BAEZAV6xu7I1ewiqzSYf6tZAnJU3rTbJYGLkQfkZCpEKUyyOALSLYyqvZAKoX13Elc3CowPYLod7Ri2zez15AGjv04iad2QAqpKWNhnzaezSuJXjztb4RYtWAaHmmQZCVnLuRxL8XZBX0Vjvd1co7dMOP0YIzBZCZCmMeSyDQ9GpAsa4qUYxdWaaWIZCoeAdywg5HdEWB6xYyd"; // Get it from https://www.phphive.info/255/get-whatsapp-password/
        
        
        $number = "8801722711523"; // Number
        $message = "Hello :)";

        $data = array(
            'messaging_product' => 'whatsapp',
            'to' => 8801712607772,
            // 'to' => 8801722711523,
            'type' => 'template',
            'template' => array(
                'name' => 'hello_world',           
                'language' => array(
                    'code' => 'en_US',
                ),          
            ),
        );
        // $data = "messaging_product\": \"whatsapp\", \"to\": \"8801712607772\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }`;

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v13.0/112528134797873/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$chatApiToken,
            'Content-Type: application/json', 
        ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }
}
