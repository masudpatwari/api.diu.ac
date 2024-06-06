<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Traits\RmsApiTraits;
use NumberToWords\NumberToWords;
use Illuminate\Support\Str;


trait MetronetSmsTraits
{
    public function send_sms($cell_number, $message)
    {
        $cell_number = substr($cell_number,-11);

        $contacts = "88{$cell_number}";

        $url = "http://joy.metrotel.com.bd/smspanel/smsapi";
        $data = [
            "api_key" => env("SMS_API_KEY"),
            "type" => "text",
            "contacts" => $contacts,
            "senderid" => env('SENDER_ID'),
            "msg" => $message,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }
}