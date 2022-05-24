<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;

class WhatsAppController extends Controller
{
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

    public function recieve()
    {
        return 'ok';
    }
}
