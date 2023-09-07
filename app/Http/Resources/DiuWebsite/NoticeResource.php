<?php

namespace App\Http\Resources\DiuWebsite;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
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
            'title' => $this->title,
            'type' => $this->type,
            'slug' => $this->slug,
            'description' => $this->description,
            'published_date' => $this->created_at ? Carbon::parse($this->created_at)->format('d / M / y') : '',
            'notice_files' => $this->noticeFiles,
        ];
    }
}