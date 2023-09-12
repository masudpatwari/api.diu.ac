<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $slug_name = str_slug(strtolower($this->NAME), '-');


        return [
            'id' => $this->ID,
            'name' => $this->NAME,
            'slug_name' => (empty($this->slug_name)) ? $slug_name : $this->slug_name,
            'site_tag' => $this->site_tag,
            'roll_no' => $this->ROLL_NO,
            'reg_code' => $this->REG_CODE,
            'year' => $this->show_profile_publicly == 1 ? $this->YEAR : null,
            'reg_sl_no' => $this->show_profile_publicly == 1 ? $this->REG_SL_NO : null,
            'department_id' => $this->show_profile_publicly == 1 ? $this->DEPARTMENT_ID : null,
            'batch_id' => $this->show_profile_publicly == 1 ? $this->BATCH_ID : null,
            'shift_id' => $this->show_profile_publicly == 1 ? $this->SHIFT_ID : null,
            'email' => $this->EMAIL,
            'phone_no' => $this->show_profile_publicly == 1 ? $this->PHONE_NO : null,
            'adm_frm_sl' => $this->show_profile_publicly == 1 ? $this->ADM_FRM_SL : null,
            'gender' => $this->show_profile_publicly == 1 ? $this->GENDER : null,
            'blood_group' => $this->show_profile_publicly == 1 ? $this->BLOOD_GROUP : null,
            'dob' => $this->show_profile_publicly == 1 ? $this->DOB : null,
            'birth_place' => $this->show_profile_publicly == 1 ? $this->BIRTH_PLACE : null,
            'parmanent_address' => $this->show_profile_publicly == 1 ? $this->PARMANENT_ADD : null,
            'mailing_address' => $this->show_profile_publicly == 1 ? $this->MAILING_ADD : null,
            'nationality' => $this->show_profile_publicly == 1 ? $this->NATIONALITY : null,
            'marital_status' => $this->show_profile_publicly == 1 ? $this->MARITAL_STATUS : null,
            'adm_date' => $this->show_profile_publicly == 1 ? $this->ADM_DATE : null,
            'birth_or_nid_no' => $this->show_profile_publicly == 1 ? $this->STD_BIRTH_OR_NID_NO : null,
            'father_name' => $this->show_profile_publicly == 1 ? $this->F_NAME : null,
            'father_cellno' => $this->show_profile_publicly == 1 ? $this->F_CELLNO : null,
            'father_occupation' => $this->show_profile_publicly == 1 ? $this->F_OCCU : null,
            'father_nid_no' => $this->show_profile_publicly == 1 ? $this->FATHER_NID_NO : null,
            'mother_name' => $this->show_profile_publicly == 1 ? $this->M_NAME : null,
            'mother_cellno' => $this->show_profile_publicly == 1 ? $this->M_CELLNO : null,
            'mother_occupation' => $this->show_profile_publicly == 1 ? $this->M_OCCU : null,
            'mother_nid_no' => $this->show_profile_publicly == 1 ? $this->MOTHER_NID_NO : null,
            'guardian_name' => $this->show_profile_publicly == 1 ? $this->G_NAME : null,
            'guardian_cellno' => $this->show_profile_publicly == 1 ? $this->G_CELLNO : null,
            'guardian_occupation' => $this->show_profile_publicly == 1 ? $this->G_OCCU : null,
            'emergency_name' => $this->show_profile_publicly == 1 ? $this->E_NAME : null,
            'emergency_cellno' => $this->show_profile_publicly == 1 ? $this->E_CELLNO : null,
            'emergency_occupation' => $this->show_profile_publicly == 1 ? $this->E_OCCU : null,
            'emergency_address' => $this->show_profile_publicly == 1 ? $this->E_ADDRESS : null,
            'emergency_relation' => $this->show_profile_publicly == 1 ? $this->E_RELATION : null,
            'blood_status' => $this->blood_status,
            'last_donate'  => $this->last_donate,
            'diu_email' => $this->diu_email,
            'wifi_username' => $this->wifi_username,
            'mac_address' => $this->mac_address,
            'about_me' => $this->show_profile_publicly == 1 ? $this->about_me : null,
            'show_profile_publicly' => $this->show_profile_publicly,
            'profile_photo' => env('APP_URL') . $this->profile_photo,
            'social_links' => $this->show_profile_publicly == 1 ? $this->relStudentSocialContact : null,
            'educations' => $this->show_profile_publicly == 1 ? $this->relStudentEducation : null,
            'has_cv' => file_exists(storage_path('students_cv/cv_' . $this->ID . '.pdf')) ? 'yes' : 'no',
        ];
    }
}
