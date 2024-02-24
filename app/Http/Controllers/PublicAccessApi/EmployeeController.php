<?php

namespace App\Http\Controllers\PublicAccessApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function employees()
    {
        $employees = Employee::orderBy('id', 'asc')->where('activestatus', '1')->get();

        if (!empty($employees))
        {
            return EmployeeResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    private function employees_group($type)
    {
        $employees = Employee::orderBy('date_of_join', 'desc')->where('activestatus', '1')->where('groups', 'like', '%'.$type.'%')->get();
        if (!empty($employees))
        {
            return EmployeeResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    public function executive_employees()
    {
        
        // return $this->employees_group('executive');
        $employees = Employee::where('activestatus', '1')->whereIn('id',[1049,786,813])->orderBy('id', 'desc')->get();
        if (!empty($employees))
        {
            return EmployeeResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    public function faculty_employees()
    {
        return $this->employees_group('faculty');
    }

    public function officers_employees()
    {
        return $this->employees_group('officers');
    }

    public function staff_employees()
    {
        return $this->employees_group('staff');
    }

    public function admission_team()
    {
        $employees = Employee::orderBy('merit', 'desc')->where('activestatus', '1')->where('groups', 'like', '%admission_team%')->get();
        if (!empty($employees))
        {
            return EmployeeResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    public function face_to_face_help()
    {
        $employees = Employee::orderBy('merit', 'desc')->where('activestatus', '1')->where('groups', 'like', '%face_to_face_help%')->get();
        if (!empty($employees))
        {
            return EmployeeResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }
}
