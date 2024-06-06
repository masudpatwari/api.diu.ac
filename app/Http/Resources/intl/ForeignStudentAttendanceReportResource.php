<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class ForeignStudentAttendanceReportResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'student_id' => $this->student_id ?? null,
            'name' => $this->relUser->name ?? null,
            'email' => $this->relUser->email ?? null,
            'registrationNo' => $this->registration_no ?? null,
            'lastClassAttainedOn' => $this->lastClassAttainedOn ?? null,            
            'daysBefore' => $this->daysBefore ?? null,
            
        ];
    }
}
