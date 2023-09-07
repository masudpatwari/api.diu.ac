<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeTimeDetailsResource extends JsonResource
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
        if ($this->type == 'fixed' || $this->type == 'offday') {
            $array = [
                'id' => $this->id,
                'type' => $this->type,
                'day' => $this->day,
                'start_time' => timestamp_to_time($this->start_time),
                'end_time' => timestamp_to_time($this->end_time),
            ];
        }
        if ($this->type == 'flexible') {
            $array = [
                'id' => $this->id,
                'type' => $this->type,
                'day' => $this->day,
                'time_duration' => timestamp_to_hours($this->time_duration),
            ];
        }
        return $array;
    }
}