<?php

namespace App\Http\Resources\rms;

use Illuminate\Http\Resources\Json\JsonResource;

class WpEmpRmsResource extends JsonResource
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
            'title' => $this->name,
            'email' => $this->email1,
            'department' => $this->dept,
            'designation' => $this->position,
            'isActiveAccount' => $this->activestatus == 1? 'Yes' : 'No',
            'isRMSAccountLocked' => $this->lock_for_rms == 1? 'Yes' : 'No',
            'private_phone_number' => $this->mno1,
            'office_email' => $this->email1,
            'ShortPosition' => $this->emp_short_position,
        ];
    }
}
