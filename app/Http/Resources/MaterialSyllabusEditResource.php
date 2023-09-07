<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialSyllabusEditResource extends JsonResource
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
            'name' => $this->name,
            'department' => $this->department,
            'published' => $this->published,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'feature' => $this->feature,
        ];
    }
}