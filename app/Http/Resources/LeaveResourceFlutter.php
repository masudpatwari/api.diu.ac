<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\LeaveYearlyReview;

class LeaveResourceFlutter extends JsonResource
{
    use LeaveYearlyReview;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status_array = [
            'Pending' => 'Pending in','Approved' => 'Approved by','Deny_By_Others' => 'Denied by','Self_Deny' => 'Self Deny','Withdraw' => 'Withdraw by'
        ];

        $array = [
            'id' => $this->id,
            'employee_name' => $this->relEmployee->name ?? '',
            'employee_designation' => $this->relEmployee->relDesignation->name ?? '',
            'employee_department' => $this->relEmployee->relDepartment->name ?? '',
            'need_permission' => $this->need_permission,
            'cause' => $this->cause,
            'created_at' => datetime_format($this->created_at),
            'kind_of_leave' => $this->relLeaveApplicationHistory()->first()->kindofleave,
            'start_date' => datestamp_to_date($this->relLeaveApplicationHistory()->first()->start_date),
            'end_date' => datestamp_to_date($this->relLeaveApplicationHistory()->first()->end_date),
            'number_of_days' => $this->relLeaveApplicationHistory()->first()->number_of_days,
            'leave_review' => $this->leave_yearly_review( $this->relEmployee->id ),
        ];

        if($this->status == 'Deny_By_Others')
        {
            $array['status'] = $status_array[$this->status];
            $array['denied_by'] = [
                'employee' => new EmployeeShortDetailsResource($this->relleaveApplicationDenyByOther->relCreatedBy),
                'denied_at' => datetime_format($this->relleaveApplicationDenyByOther->created_at),
            ];
        }

        if($this->status == 'Pending'){
//            $array['pending_in'] = $this->pendingIn($this->relPendingInEmployee);
            $array['boss_name'] = $this->relPendingInEmployee->name ?? '';
            $array['boss_designation'] = $this->relPendingInEmployee->relDesignation->name ?? '';
            $array['boss_department'] = $this->relPendingInEmployee->relDepartment->name ?? '';
            $array['status'] = $status_array[$this->status];
        }
        if($this->status == 'Approved'){
            $array['approved_by'] = new EmployeeShortDetailsResource($this->relPendingInEmployee);
            $array['status'] = $status_array[$this->status];
        }

        return $array;
    }

//    private function pendingIn($employee){
//        return [
//            'boss_name' => $employee->name ?? '',
//            'boss_designation' => $employee->relDesignation->name ?? ''
//        ];
//    }
}