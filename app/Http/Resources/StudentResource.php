<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $slug_name = str_replace(["."," ","(",")"], ["."], strtolower($this->NAME));
        return [
            'id' => $this->ID,
            'name' => $this->NAME,
            'slug_name' => (empty($this->slug_name)) ? $slug_name : $this->slug_name,
            'roll_no' => $this->ROLL_NO,
            'reg_code' => $this->REG_CODE,
            'email' => $this->EMAIL,
            'blood_status' => $this->blood_status,
            'profile_photo' => (!empty($this->profile_photo)) ? env('APP_URL').'/'.$this->profile_photo : NULL,
        ];
    }
}