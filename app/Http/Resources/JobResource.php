<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'total_row' => $this->total_row,
            'queue' => $this->queue,
            'start_at' => date("Y-m-d h:i:s A", $this->start_at),
            'end_at' => date("Y-m-d h:i:s A", $this->end_at),
        ];
    }
}