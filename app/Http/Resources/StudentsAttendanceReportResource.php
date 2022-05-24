<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentsAttendanceReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $preserveKeys = true;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'department_name' => $this->department_name,
            'batch_name' => $this->batch_name,
            'semester' => $this->semester,
            'course_name' => $this->course_name,
            'course_code' => $this->course_code,
            'status' => $this->status,
        ];
    }
}