<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class ForeignStudentDocResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'fileName' => $this->filename,
            'title' => $this->title,
            'extension' => $this->extension,
            'created_at' => $this->created_at->format("Y-m-d H:i:s"),
            'url' => env('APP_URL') . 'images/foreign_student_doc/'. $this->filename,
        ];
    }
}
