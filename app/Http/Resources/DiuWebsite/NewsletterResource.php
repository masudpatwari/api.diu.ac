<?php

namespace App\Http\Resources\DiuWebsite;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsletterResource extends JsonResource
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
            'id'            => $this->id,
            'email'         => $this->email,
            'status'        => $this->status,
            'created_at'    => Carbon::parse($this->created_at)->format('d-m-Y h:m:s A'),
        ];
    }
}