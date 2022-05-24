<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public $preserveKeys = true;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug_name' => $this->slug_name,
            'type' => $this->type,
            'designation' => $this->relDesignation->name,
            'department' => $this->relDepartment->name,
            'office_email' => $this->office_email,
            'jobtype' => $this->jobtype,
            'campus' => $this->relCampus->name,
            'phone_no' => $this->personal_phone_no,
            'alternative_phone_no' => $this->alternative_phone_no,
            'office_address' => $this->office_address,
            'profile_photo_file' => $this->profile_photo_file,
            'photo_url' => env('APP_URL') . $this->profile_photo_file,
            'salary_report_priority' => $this->salary_report_sort_id,
            'website' => env('PROFILE_WEBSITE_URL') . '' . $this->slug_name,
            'rmsEmployeeId' => $this->rmsEmployee->id ?? '',
            'average_rating' => number_format($this->average_rating, 2) ?? 0,
            'total_rating_provider' => $this->total_rating_provider ?? 0,
        ];
    }
}