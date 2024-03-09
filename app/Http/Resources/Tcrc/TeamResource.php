<?php

namespace App\Http\Resources\Tcrc;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->employee->name ?? null,
            'tcrc' => $this->designation ?? null,
            'designation' => $this->employee->relDesignation->name ?? null,
            'profile_image' => env('APP_URL') . $this->employee->profile_photo_file,
            'profile_link' => "https://profile.diu.ac/{$this->employee->slug_name}",
        ];
    }
}