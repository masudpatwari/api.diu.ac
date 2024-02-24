<?php

namespace App\Http\Resources;

use App\Models\STD\StaffsServiceCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackEmployeeResource extends JsonResource
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
            'designation' => $this->relDesignation->name,
            'department' => $this->relDepartment->name,
            'photo_url' => env('APP_URL') . $this->profile_photo_file,
            'feedbackCategories' => StaffsServiceCategory::wherestatus(1)->get(),
            'select' => false,

        ];
    }
}