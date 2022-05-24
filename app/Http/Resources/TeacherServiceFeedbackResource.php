<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherServiceFeedbackResource extends JsonResource
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
            'semester'=>$this->semester,
            'course_id'=>$this->course_id,
            'course_code'=>$this->course_code,
            'course_name'=>$this->course_name,
            'teacher_name'=>$this->teacher_name,
            'teacher_position'=>$this->teacher_position,
            'skill_increase'=>$this->skill_increase,
            'other_comments'=>$this->other_comments,
            'created_at' => $this->created_at ? \Carbon\Carbon::parse($this->created_at)->format('h:i A,d F ,Y') : null,
            'totalPoint'=>$this->totalPoint ?? '',
            'student'=>$this->student,
            'teacherServiceFeedbackDetails'=>$this->teacherServiceFeedbackDetails ?? '',
        ];
    }
}