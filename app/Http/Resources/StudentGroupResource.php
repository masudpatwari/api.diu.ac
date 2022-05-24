<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentGroupResource extends JsonResource
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
            'id' => $this->ID,
            'name' => $this->NAME,
            'short_code' => $this->SHORT_CODE,
            'students' => StudentResource::collection($this->relStudent->take(4)),
        ];
    }
}