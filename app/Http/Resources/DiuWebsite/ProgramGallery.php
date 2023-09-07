<?php

namespace App\Http\Resources\DiuWebsite;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramGallery extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}