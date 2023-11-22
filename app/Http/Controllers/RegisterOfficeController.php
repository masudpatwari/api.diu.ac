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



class RegisterOfficeController extends Controller
{
    use RmsApiTraits;

    public function get_student_info($reg)
    { 
        return $this->get_readmission_student_info($reg);   
        
        
    }
    public function readmission_store(Request $request)
    {
        $request['emp_id'] = $request->auth->id;
        // return $request->all();
        return $this->readmission_student_store($request->all());

    }
    public function get_department($short_code)
    { 
        return $this->get_department_by_short_code($short_code);   
        
        
    }



   

   
}
