<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class VisaExpireResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'student_id' => $this->student_id,
            'name' => $this->relUser->name,
            'email' => $this->relUser->email,
            'bd_mobile' => $this->bd_mobile,
            'registration_no' => $this->registration_no,
            'visa_date_of_issue' => $this->visa_issue_date??'---',
            'visa_date_of_expire' => $this->visa_expire_date??'---',
            'remain_days' => $this->remainDays,
            'accouts_info' => $this->accoutsInfo,
            'last_class' => [
                                'date' => $this->lastClass
                                    ? $this->lastClass->created_at->format('d F, Y')
                                    : 'NF',

                                'days_before' => $this->lastClass
                                    ? $this->lastClass->daysBefore
                                    : '--',
                            ],
            
        ];
    }
}
