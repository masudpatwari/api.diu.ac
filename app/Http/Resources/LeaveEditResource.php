<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Designation;
use App\Department;

class LeaveEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $relLeaveApplicationHistory = $this->relLeaveApplicationHistory->first();
        return [
            'id' => $this->id,
            'kind_of_leave' => $relLeaveApplicationHistory->kindofleave,
            'start_date' => datestamp_to_date($relLeaveApplicationHistory->start_date),
            'end_date' => datestamp_to_date($relLeaveApplicationHistory->end_date),
            'number_of_days' => $relLeaveApplicationHistory->number_of_days,
        ];
    }
}