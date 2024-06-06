<?php

namespace App\Http\Resources\intl;

use Illuminate\Http\Resources\Json\JsonResource;

class VisaExpireResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'student_id' => $this->student_id ?? null,
            'name' => $this->relUser->name ?? null,
            'email' => $this->relUser->email ?? null,
            'bd_mobile' => $this->bd_mobile ?? null,
            'registration_no' => $this->registration_no ?? null,
            'visa_date_of_issue' => $this->visa_issue_date??'---',
            'visa_date_of_expire' => $this->visa_expire_date??'---',
            'remain_days' => $this->remainDays ?? null,
            'accouts_info' => $this->accoutsInfo ?? null,
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
