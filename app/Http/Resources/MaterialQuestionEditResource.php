<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialQuestionEditResource extends JsonResource
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
            'description' => $this->description,
        ];
    }
}