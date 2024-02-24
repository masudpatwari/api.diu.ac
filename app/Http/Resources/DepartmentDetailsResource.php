<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Designation;
use App\Department;

class DepartmentDetailsResource extends JsonResource
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
            'type' => $this->type,
            'created_by' => new EmployeeShortDetailsResource($this->relCreatedBy),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}