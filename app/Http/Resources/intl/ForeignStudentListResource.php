<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class ForeignStudentListResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'foreign_student_table_id' => $this->id,
            'student_id' => $this->student_id,
            'name' => $this->relUser->name??'NA',
            'email' => strtolower($this->relUser->email??'NA'),
            'registration_no' => $this->registration_no,            
            'interested_subject' => $this->interested_subject,            
        ];
    }
}
