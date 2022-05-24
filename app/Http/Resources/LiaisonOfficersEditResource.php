<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiaisonOfficersEditResource extends JsonResource
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
            'father_name' => $this->fatherName,
            'division_id' => $this->division,
            'district_id' => $this->district,
            'police_station_id' => $this->ps,
            'address' => $this->address,
            'occupation' => $this->occupation,
            'institute' => $this->institute,
            'email' => $this->email,
            'mobile' => $this->mobile1,
            'another_mobile_no' => $this->mobile2,
            'code' => $this->code,
            'officer_mobile_number' => $this->officerMobileNumber,
            'payment_method' => $this->payment_method,
            'mobile_banking_number' => $this->mobile_banking_number,
        ];
    }
}