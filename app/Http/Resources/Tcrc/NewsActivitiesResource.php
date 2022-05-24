<?php

namespace App\Http\Resources\Tcrc;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsActivitiesResource extends JsonResource
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
            'type' => $this->type,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_path' => $this->image_path,
            'created_at' => Carbon::parse($this->created_at)->format('d M, Y'),
            'created_date_month' => Carbon::parse($this->created_at)->format('d M'),
            'created_year' => Carbon::parse($this->created_at)->format('Y'),
            'creator_name' => $this->user->name,
            'creator_image' => env('APP_URL') . $this->user->profile_photo_file,
            'creator_slug' => "https://profile.diu.ac/{$this->user->slug_name}",
        ];
    }
}