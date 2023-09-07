<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TranscriptVerificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transcript_link = NULL;
        if ($this->has_file) {
            $transcript_link = env('APP_URL').'transcript/download/'.$this->filename.'/'.md5($this->filename);
        }
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'roll'=> $this->roll,
            'regcode'=> $this->regcode,
            'transcript_department_id'=> $this->transcript_department_id,
            'program'=> $this->relDepartments->name_output,
            'batch'=> $this->batch,
            'session'=> $this->session,
            'shift'=> $this->shift,
            'cgpa'=> $this->cgpa,
            'passing_year'=> $this->passing_year,
            'has_file'=> $this->has_file,
            'verified'=> $this->verified==1?'Yes':'No',
            'transcript_link'=> $transcript_link,
        ];
    }
}