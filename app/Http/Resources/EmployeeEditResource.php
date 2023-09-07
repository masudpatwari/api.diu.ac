<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeEditResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug_name' => $this->slug_name,
            'type' => $this->type,
            'designation_id' => $this->designation_id,
            'department_id' => $this->department_id,
            'office_email' => $this->office_email,
            'private_email' => $this->private_email,
            'personal_phone_no' => $this->personal_phone_no,
            'alternative_phone_no' => $this->alternative_phone_no,
            'spous_phone_no' => $this->spous_phone_no,
            'parents_phone_no' => $this->parents_phone_no,
            'other_phone_no' => $this->other_phone_no,
            'office_phone_no' => $this->office_phone_no,
            'home_phone_no' => $this->home_phone_no,
            'gurdian_phone_no' => $this->gurdian_phone_no,
            'jobtype' => $this->jobtype,
            'date_of_birth' => datestamp_to_date($this->date_of_birth),
            'date_of_join' => datestamp_to_date($this->date_of_join),
            'campus_id' => $this->campus_id,
            'nid_no' => $this->nid_no,
            'office_address' => $this->office_address,
            'profile_photo_file' => $this->profile_photo_file,
            'signature_card_photo_file' => $this->signature_card_photo_file,
            'cover_photo_file' => $this->cover_photo_file,
            'weekly_working_hours' => $this->weekly_working_hours,
            'attendance_card_id' => $this->relAttendanceIds->att_data_id,
            'attendance_id' => $this->relAttendanceIds->att_card_id,
            'short_position_id' =>$this->shortPosition_id,
            'role_ids' =>$this->relEmployeeRole->pluck('role_id')->toArray(),
            'supervised_by' =>$this->supervised_by,
            'active_status' =>$this->activestatus,
            'overview' => $this->overview,
            'groups' => $this->groups,
            'merit' => $this->merit,
            'salary_report_sort_id' => $this->salary_report_sort_id,
        ];
    }
}