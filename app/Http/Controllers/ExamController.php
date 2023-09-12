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

   

   
}
