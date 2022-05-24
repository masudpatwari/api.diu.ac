<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Designation;
use App\Department;

class SystemSettingHistoryResource extends JsonResource
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
            'key' => $this->key,
            'value' => $this->value,
            'deleted_at' => datetime_format($this->deleted_at),
            'created_by' => new EmployeeShortDetailsResource($this->relCreatedBy),
            'deleted_by' => new EmployeeShortDetailsResource($this->relDeletedBy),
        ];
    }
}