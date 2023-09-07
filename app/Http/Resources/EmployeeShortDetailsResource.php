<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeShortDetailsResource extends JsonResource
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
            'name' => $this->name ?? '',
            'email' => $this->office_email,
            'designation' => $this->relDesignation->name,
            'department' => $this->relDepartment->name,
            'office_email' => $this->office_email,
            'personal_phone_no' => $this->personal_phone_no,
            'jobtype' => $this->jobtype,
            'campus' => $this->relCampus->name,
            'profile_photo_file' => $this->profile_photo_file,
            'profilepic' => env('APP_URL').''.$this->profile_photo_file,
            'groups' => $this->groups,
            'website' => env('PROFILE_WEBSITE_URL').''.$this->slug_name,
        ];
    }
}