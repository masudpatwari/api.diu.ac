<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialLectureSheetEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->course_name,
            'department' => $this->department,
            'course_code' => $this->course_code,
            'semester' => $this->semester,
            'published' => $this->published,
            'session' => $this->session,
            'submission_date' => date('Y-m-d', strtotime($this->submission_date)),
            'prepared_by' => $this->prepared_by,
        ];
    }
}