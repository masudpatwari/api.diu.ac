<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
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
            'date'=> $this->date,
            'link'=> $this->link,
            'title'=> $this->title->rendered,
            'content'=> $this->content->rendered,
            'excerpt'=> $this->excerpt->rendered,
        ];
    }
}
