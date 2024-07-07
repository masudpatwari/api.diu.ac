<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Employee;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;

class BankController extends Controller
{
    use RmsApiTraits;

    public function getStudents()
    {
        return $this->trait_getStudents();
    }

    public function getStudentDetail( Request $request)
    {
        return $this->trait_getStudentDetail( $request);

    }

    public function searchStudent( Request $request)
    {       
    
        return $this->trait_searchStudentInfo($request);

    }   

    public function confirmPayment( Request $request)
    { 
        return $this->trait_confirmPayment($request);  

    }

    public function transectionInfo( Request $request)
    { 
        return $this->bankTransectionInfo($request);  

    }
    public function transectionDelete( Request $request,$receipt_no)
    { 
        return $this->bankTransectionDelete($request, $receipt_no);  

    }


    public function test(Request $request){
        // $token = Str::random(100);
        // return $token;

        // Retrieve the IP address of the client
        $ip = $request->ip();

        // Now you have the IP address, you can use it as needed
        return $ip;
    }


}
