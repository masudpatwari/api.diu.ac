<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LibraryTeamResource extends JsonResource
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
//            'id' => $this->id,
            'name' => $this->employee->name ?? 'N/A',
            'designation' => $this->employee->relDesignation->name ?? 'N/A',
            'department' => $this->employee->relDepartment->name ?? 'N/A',
            'email' => $this->employee->office_email ?? 'N/A',
            'image_url' => env('APP_URL') . $this->employee->profile_photo_file ?? 'N/A',
//            'employee'=>$this->employee,
        ];
    }
}