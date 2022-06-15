<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;


class WhatsAppController extends Controller
{
    public function index()
    {
        return  $messages = Curl::to('https://webhook.diu.ac/get-messages')
                                ->asJson(true)
                                ->get();
    }

    
    public function send()
    {
        dd(WhatsApp::all());
    }

}

