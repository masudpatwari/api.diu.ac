<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => datestamp_to_date($this->start_date),
            'end_date' => datestamp_to_date($this->end_date),
            'number_of_days' => $this->number_of_days,
            'cause' => $this->cause,
        ];
    }
}