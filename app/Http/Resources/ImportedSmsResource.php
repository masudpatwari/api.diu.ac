<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImportedSmsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'mobilenumber'=> $this->mobilenumber,
            'message'=> $this->message,
            'message_time'=> $this->message_time,
            'created_at'=> $this->created_at,
            'action_status'=> $this->action_status,
            'created_by'=> $this->created_by,
        ];
    }
}
