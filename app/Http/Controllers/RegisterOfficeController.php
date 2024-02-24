<?php

namespace App\Http\Controllers;

use App\ApiKey;
use App\Models\STD\Student;

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

    public function convocation_information($batch_id){
         $data =  $this->get_convocation_information($batch_id); 


         $transformedData = collect($data['data'])->transform(function ($student) {
            $studentDetails = Student::where('reg_code', $student['reg_code'])->first();
        
            return [
                'id' => $student['id'] ?? 'Unavailable',
                'name' => $student['name'] ?? 'Unavailable',
                'role' => $student['roll_no'] ?? 'Unavailable',
                'reg_code' => $student['reg_code'] ?? 'Unavailable',               
                'admission_year' => $student['year'] ?? 'Unavailable',               
                'dob' => isset($student['dob']) ? Carbon::parse($student['dob'])->format('Y-m-d') : 'Unavailable',               
                'ssc_year' => $student['e_passing_year1'] ?? 'Unavailable',               
                'ssc_cgpa' => $student['e_div_cls_cgpa1'] ?? 'Unavailable',               
                'ssc_group' => $student['e_group1'] ?? 'Unavailable',               
                'hsc_year' => $student['e_passing_year2'] ?? 'Unavailable',               
                'hsc_cgpa' => $student['e_div_cls_cgpa2'] ?? 'Unavailable', 
                'hsc_group' => $student['e_group2'] ?? 'Unavailable',  
                'honours_year' => $student['e_passing_year3'] ?? 'Unavailable',               
                'honours_cgpa' => $student['e_div_cls_cgpa3'] ?? 'Unavailable', 
                'honours_group' => $student['e_group3'] ?? 'Unavailable',                
                'email' =>  $studentDetails->EMAIL ?? $student['email'] ??'Unavailable' ,               
                'phone' =>  $studentDetails->PHONE_NO ?? $student['phone_no'] ?? 'Unavailable',               
               
            ];
        });

       return  $transformedData;

     

   

    }



   

   
}
