<?php

namespace App\Http\Controllers\STD\Feedback;

use App\Employee;
use App\Department;
use App\Models\STD\StaffsServiceCategory;
use App\Models\STD\TeacherServiceCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackEmployeeResource;


class FetchFeedbackDataController extends Controller
{
    public function employeeDepartment()
    {
        return Department::whereType('non-academic')->get();
    }

    public function departmentWiseEmployeeLists($departmentId)
    {
        return FeedbackEmployeeResource::collection(Employee::with('relDesignation', 'relDepartment')->whereDepartmentId($departmentId)->whereActivestatus(1)->get());
    }

}
