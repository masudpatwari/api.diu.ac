<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'faculty_name' => $this->relFaculty->name,
            'department_name' => $this->relDepartment->name,
            'name' => $this->name,
            'status' => $this->status,
            'short_name' => $this->short_name,
            'description' => $this->description,
            'duration' => $this->duration,
            'credit' => $this->credit,
            'semester' => $this->semester,
            'tuition_fee' => $this->tuition_fee,
            'int_tuition_fee' => $this->international_tuition_fee,
            'admission_fee' => $this->admission_fee,
            'total_fee' => $this->total_fee,
            'shift' => $this->shift,
            'type' => $this->type,
            'last_update' => datetime_format($this->updated_at),
            'created_by' => new EmployeeShortDetailsResource($this->relCreatedBy),
        ];
    }
}