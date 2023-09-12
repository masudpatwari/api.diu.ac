<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class ForeignStudentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'foreign_student_table_id' => $this->id,
            'student_id' => $this->student_id,
            'name' => $this->relUser->name,
            'email' => strtolower($this->relUser->email),
            'registration_no' => $this->registration_no,
            'is_admitted' => $this->is_admitted,
            'visa_date_of_issue' => $this->visa_date_of_issue,
            'visa_date_of_expire' => $this->visa_date_of_expire,
            'admitted_by' => $this->relReferralBy->name??'NA',
            'admitted_by_id' => $this->relReferralBy->id??'NA',
            
        ];
    }
}
