<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentServiceFeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'semester' => $this->semester,
            'information_admission_and_registration_branch' => $this->information_admission_and_registration_branch,
            'office_of_the_registrar' => $this->office_of_the_registrar,
            'office_of_the_controller_of_examinations' => $this->office_of_the_controller_of_examinations,
            'dean_branch' => $this->dean_branch,
            'office_of_the_head_co_ordinator_of_the_department' => $this->office_of_the_head_co_ordinator_of_the_department,
            'program_officer' => $this->program_officer,
            'library' => $this->library,
            'labs_and_laboratories' => $this->labs_and_laboratories,
            'internet_and_wifi' => $this->internet_and_wifi,
            'canteen_and_cafeteria' => $this->canteen_and_cafeteria,
            'permanent_campus' => $this->permanent_campus,
            'improve_university_service' => $this->improve_university_service,
            'agree_for_class_permanent_campus' => $this->agree_for_class_permanent_campus,
            'created_at' => $this->created_at ? \Carbon\Carbon::parse($this->created_at)->format('h:i A, d F ,Y') : null,
            'student' => $this->student,
            'employeeDepartment' => $this->department ?? '',
            'staffServiceInfoFeedbacks' => $this->staffServiceInfoFeedbacks ?? '',
        ];
    }
}