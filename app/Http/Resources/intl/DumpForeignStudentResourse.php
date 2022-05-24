<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class DumpForeignStudentResourse extends JsonResource
{

    public function toArray($request)
    {
        return [
            'foreign_student_table_id' => $this->id,
            'student_id' => $this->student_id,
            'name' => $this->relUser->name,
            'email' => strtolower($this->relUser->email),
            'registration_no' => $this->registration_no,            
            'date_of_dump' => $this->dump_date->format("d F, Y @ H:i"),            
            'cause_of_dump' => $this->dump_cause,            
            'passport_no' => $this->passport_no,
        ];
    }
}
