<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeTimeResource extends JsonResource
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
        $array['employee'] = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->office_email,
            'designation' => $this->relDesignation->name,
            'department' => $this->relDepartment->name,
            'profile_photo_file' => $this->profile_photo_file,
        ];
        $array['office_times'] = OfficeTimeDetailsResource::collection($this->relOfficeTime);
        $array['weekly_working_hours'] = $this->weekly_working_hours;
        
        return $array;
    }
}