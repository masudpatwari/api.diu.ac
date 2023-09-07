<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class ForeignStudentAttendanceReportResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'student_id' => $this->student_id,
            'name' => $this->relUser->name,
            'email' => $this->relUser->email,
            'registrationNo' => $this->registration_no,
            'lastClassAttainedOn' => $this->lastClassAttainedOn,            
            'daysBefore' => $this->daysBefore,
            
        ];
    }
}
