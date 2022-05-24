<?php

namespace App\Http\Controllers\CMS;

use App\Traits\Microsoft;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MicrosoftController extends Controller
{
    use Microsoft;
    public function index()
    {
        $token = $this->token();

        $data = [
            'token' => $token ?? 'N/A',
        ];

        return $data;
    }

}
