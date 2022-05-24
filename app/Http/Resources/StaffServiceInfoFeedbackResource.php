<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffServiceInfoFeedbackResource extends JsonResource
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
            'totalPoint' => $this->totalPoint,
            'created_at' => Carbon::parse($this->created_at)->format('h:i A , d-m-Y'),
            'staffServiceFeedback' => $this->staffServiceFeedback ?? '',
            'staffServiceInfoFeedbackDetails' => $this->staffServiceInfoFeedbackDetails ?? '',
        ];
    }
}