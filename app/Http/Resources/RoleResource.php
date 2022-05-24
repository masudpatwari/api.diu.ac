<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'role_name' => $this->name,
            'role_slug' => $this->slug,
            'created_by' => new EmployeeShortDetailsResource($this->relCreatedBy),
            'deleted_by' => new EmployeeShortDetailsResource($this->relDeletedBy),
        ];
    }
}