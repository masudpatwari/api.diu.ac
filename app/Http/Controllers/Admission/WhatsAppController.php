<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\WhatsApp\WhatsAppTemplate;
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

    public function loadTemplate($type)
    {
        $templates = WhatsAppTemplate::where('type', $type)->get();

        if(count($templates) > 0)
        {
            return $templates;
        }else{
            return response(['error' => 'No Template Found'], 404);
        }
    }

    public function getTemplates()
    {
        $templates = WhatsAppTemplate::get()->groupBy('type');

        if(count($templates) > 0)
        {
            return $templates;
        }else{
            return response(['error' => 'No Template Found'], 404);
        }
    }

}

