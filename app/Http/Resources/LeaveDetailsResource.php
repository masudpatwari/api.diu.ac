<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveDetailsResource extends JsonResource
{
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
        
        $comments = NULL;
        if ($request->auth->id != $this->employee_id) {
            $comments = LeaveApplicationCommentResource::collection($this->relleaveApplicationComment()->orderBy('id', 'desc')->get());
        }
        

        $array = [
            'id' => $this->id,
            'employee' => new EmployeeShortDetailsResource($this->relEmployee),
            'need_permission' => $this->need_permission,
            'accept_salary_difference' => $this->accept_salary_difference,
            'cause' => $this->cause,
            'created_at' => datetime_format($this->created_at),
            'leave_details' => LeaveApplicationHistoryResource::collection($this->relLeaveApplicationHistory)->first(),
            'leave_history' => LeaveApplicationHistoryResource::collection($this->relLeaveApplicationHistory()->onlyTrashed()->orderBy('created_at', 'desc')->get()),
            'comments' => $comments,
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
            $array['pending_in'] = new EmployeeShortDetailsResource($this->relPendingInEmployee);
            $array['status'] = $status_array[$this->status];
        }
        if($this->status == 'Approved'){
            $array['approved_by'] = new EmployeeShortDetailsResource($this->relPendingInEmployee);
            $array['status'] = $status_array[$this->status];
        }

        return $array;
    }
}