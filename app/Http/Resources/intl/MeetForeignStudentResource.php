<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Employee;

class MeetForeignStudentResource extends JsonResource
{

    public function toArray($request)
    {
        $employeeReturnArray = [];

        $employee = Employee::with(['relDesignation','relDepartment'])->find($this->meet_by);
        if ( ! $employee ) {
            $employeeReturnArray = [
                'name' =>'NA',
                'office_email' =>'NA',
                'personal_phone_no' =>'NA',
                'designation' =>'NA',
                'department' =>'NA',
            ];
        }else{
            $employeeReturnArray = [
                'name' => $employee->name,
                'office_email' => $employee->office_email,
                'personal_phone_no' => $employee->personal_phone_no,
                'designation' =>$employee->relDesignation->name,
                'department' => $employee->relDepartment->name,
            ];
        }

        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'comment' => $this->comment,
            'next_date' => $this->next_date? $this->next_date->format('d F, Y') : '',
            'extension' => $this->extension,
            'employee' => $employeeReturnArray,
            'image_url' => $this->extension==''?'':env('APP_URL').'/images/meet_image/' . $this->id . '.' . $this->extension  ,
            'created_at' => $this->created_at->format('d F, Y @ h:i:s a')  ,
            
        ];
    }
}
