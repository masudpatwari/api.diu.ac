<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SwitchOffdayEditResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'offday_date'=>  datestamp_to_date($this->offdayDate),
            'change_to_date'=>  datestamp_to_date($this->changeToDate),
        ];
    }
}
