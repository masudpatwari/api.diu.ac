<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeProfileResource extends JsonResource
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
            'designation' => $this->relDesignation->name,
            'department' => $this->relDepartment->name,
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
            'campus' => $this->relCampus->name,
            'nid_no' => $this->nid_no,
            'office_address' => $this->office_address,
            'profile_photo_file' => $this->profile_photo_file,
            'signature_card_photo_file' => $this->signature_card_photo_file,
            'cover_photo_file' => $this->cover_photo_file,
            'weekly_working_hours' => $this->weekly_working_hours,
            'attendance_card_id' => $this->relAttendanceIds->att_data_id ?? 'NA',
            'attendance_id' => $this->relAttendanceIds->att_card_id ?? 'NA',
            'short_position' => [
                'name' => $this->relShortPosition->name,
                'description' => $this->relShortPosition->description,
            ],
            'overview' => $this->overview,
            'relGallery' => $this->relGallery,
            'academic_qualifications' => AcademicQualificationsResource::collection($this->relAcademicQualifications),
            'training_experience' => TrainingExperiencesResource::collection($this->relTrainingExperience),
            'area_of_skills' => AreaOfSkillsResource::collection($this->relAreaOfSkills),
            'publications' => PublicationsResource::collection($this->relPublications),
            'awards' => AwardScholarshipsResource::collection($this->relAwards),
            'expart_on' => ExpartOnResource::collection($this->relExpartOn),
            'socials' => SocialContactsResource::collection($this->relSocial),
            'employment' => PreviousEmploymentsResource::collection($this->relEmployment),
            'counseling_hour' => CounsellingHoursResource::collection($this->relCounselingHour),
            'memberships' => MemberShipsResource::collection($this->relMemberships),
            'website' => env('PROFILE_WEBSITE_URL').''.$this->slug_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'average_rating' => number_format($this->average_rating, 2) ?? 0,
            'total_rating_provider' => $this->total_rating_provider ?? 0,
        ];
    }
}







