<?php

namespace App\Http\Resources\DiuWebsite;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramBasicInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'introduction' => $this->introduction,
            'mission' => $this->mission,
            'vission' => $this->vission,
            'department_head_speach' => $this->department_head_speach,
            'chairman_name' => $this->employee->name ?? 'N/A',
            'chairman_image' => env('APP_URL') . $this->employee->profile_photo_file ?? 'N/A',
            'chairman_slug' => $this->employee->slug_name ?? 'N/A',
            'chairman_office_email' => $this->employee->office_email ?? 'N/A',
            'chairman_designation' => $this->employee->relDesignation->name ?? 'N/A',
        ];
    }
}