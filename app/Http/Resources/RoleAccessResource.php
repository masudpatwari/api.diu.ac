<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleAccessResource extends JsonResource
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
        $data['roles'] = [
            'id' => $this->id,
            'role_name' => $this->name,
            'role_slug' => $this->slug,
        ];
        return $data;
    }
}