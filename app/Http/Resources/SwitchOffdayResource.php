<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SwitchOffdayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    // public $preserveKeys = true;

    public function toArray($request)
    {

        $returnData = [
            'id' => $this->id,
            'offday_date' =>  datestamp_to_date($this->offdayDate),
            'change_to_date' =>  datestamp_to_date($this->changeToDate),
            'approved_by_supervisor' =>  $this->approvedBySupervisor ? 'Approved' : 'Not Approved',
            'created_at' =>  $this->created_at->toDateTimeString(),
            'pending_on' => new EmployeeShortDetailsResource($this->relSupervisorEmployee),
            'create_by' => new EmployeeShortDetailsResource($this->relCreatedByEmployee),
        ];

        if ($this->deleted_by) {
            $returnData['deleted_by'] = new EmployeeShortDetailsResource($this->relDeletedByEmployee);
            $returnData['deleted_at'] = $this->deleted_at;
        }

        return $returnData;
    }
}
