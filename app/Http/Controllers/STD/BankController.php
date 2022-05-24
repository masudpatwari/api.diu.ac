<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use App\Employee;
use Ixudra\Curl\Facades\Curl;

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


}
