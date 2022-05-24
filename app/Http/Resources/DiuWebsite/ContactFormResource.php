<?php

namespace App\Http\Resources\DiuWebsite;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactFormResource extends JsonResource
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
            'full_name' => $this->first_name . ' ' . $this->last_name ?? '',
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('d-m-Y h:i:s A') : '',
        ];
    }
}