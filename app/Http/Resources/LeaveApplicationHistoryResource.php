<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Designation;
use App\Department;

class LeaveApplicationHistoryResource extends JsonResource
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
            'kind_of_leave' => $this->kindofleave,
            'start_date' => datestamp_to_date($this->start_date),
            'end_date' => datestamp_to_date($this->end_date),
            'number_of_days' => $this->number_of_days,
            'created_by' => new EmployeeShortDetailsResource($this->relCreatedBy),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}