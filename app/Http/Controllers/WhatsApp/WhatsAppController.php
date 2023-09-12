<?php

namespace App\Http\Controllers\WhatsApp;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Radcheck;
use Illuminate\Support\Facades\DB;

class WhatsAppController extends Controller
{
    public function api_sms()
    {
        $chatApiToken = "EAALXQC2uJj8BAEZAV6xu7I1ewiqzSYf6tZAnJU3rTbJYGLkQfkZCpEKUyyOALSLYyqvZAKoX13Elc3CowPYLod7Ri2zez15AGjv04iad2QAqpKWNhnzaezSuJXjztb4RYtWAaHmmQZCVnLuRxL8XZBX0Vjvd1co7dMOP0YIzBZCZCmMeSyDQ9GpAsa4qUYxdWaaWIZCoeAdywg5HdEWB6xYyd"; // Get it from https://www.phphive.info/255/get-whatsapp-password/
        

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

    public function recieve()
    {
        return
        $mobile_nos = DB::connection('intl')->table('local_students')->where('is_admitted', 'false')
            ->where('created_at', '>=', '2021-01-01')
            ->pluck('mobile_no');


//        $number?

        return  json_encode(array_values($mobile_nos->toArray()));
        return view('pbx');
        dd(trim('   ok   '));
//        $duplicates = Radcheck::selectRaw("identification, COUNT(*) AS count")->groupBy("identification")->get();
        $deactivated_employees = Employee::where('activestatus', 0)->pluck('office_email');

        $deletable_mails = [];

        if($deactivated_employees){
            foreach ($deactivated_employees as $employee) {
                if (ends_with($employee, 'diu-bd.net')){
                    $deletable_mails[] = str_replace('diu-bd.net', 'diu.ac', $employee);
                }else{
                    $deletable_mails[] = $employee;
                }
            }


            foreach ($deletable_mails as $mail)
            {
                $hasWifi = Radcheck::where('identification', $mail)->first();

                if($hasWifi)
                {
                    $hasWifi->delete();
                }
            }
        }

//        $ids_six_disit = [];
//
//        foreach($duplicates as $duplicate)
//        {
//            if($duplicate->count > 1)
//            {
////                Radcheck::where('identification', $duplicate->identification)->oldest('id')->take
////                ($duplicate->count-1)->delete();
//                dd($duplicate);
//            }
////            if(strlen($identification) == 6){
//////                $ids_six_disit[] = $identification;
////
//////                $new_mail = str_replace('diu-bd.net', 'diu.ac', $email);
//////                return
////                $redInfo = Radcheck::where('identification', $identification)->first()->delete();
////
//////                $redInfo->update([
//////                    'identification' => $new_mail
//////                ]);
////            }
//        }
//
        return $deletable_mails;
    }

//    public function wifiDelete()
//    {
//        return
//
//    }
}
