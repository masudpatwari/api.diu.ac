<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileTeacherServiceFeedbackResource extends JsonResource
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
            'id'=>$this->id,
//            'totalPoint' => $this->totalPoint,
            'skill_increase'=>$this->skill_increase,
            'other_comments'=>$this->other_comments,
//            'created_at' => $this->created_at ? \Carbon\Carbon::parse($this->created_at)->format('h:i A,d F ,Y') : null,
//            'feedbackDetails'=>$this->teacherServiceFeedbackDetails ?? '',
        ];
    }
}