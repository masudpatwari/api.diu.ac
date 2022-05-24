<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'purpose' => $this->purpose,
            'status' => $this->status,
            'type' => $this->type,
            'priority' => $this->priority,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'assaign_to' => $this->assaign_to,
            'assign_date_time' => $this->assign_date_time ? \Carbon\Carbon::parse($this->assign_date_time)->format('h:i A , d M ,Y') : null,
            'deny_reason' => $this->deny_reason,
            'canceled_by' => $this->canceled_by,
            'cancel_date_time' => $this->cancel_date_time ? \Carbon\Carbon::parse($this->cancel_date_time)->format('h:i A , d M ,Y') : null,
            'completed_by' => $this->completed_by,
            'completed_date_time' => $this->completed_date_time ? \Carbon\Carbon::parse($this->completed_date_time)->format('h:i A , d M ,Y') : null,
            'permission_details' => $this->permission_details,
            'permission_seeker_id' => $this->permission_seeker_id,
            'permission_status' => $this->permission_status,
            'permission_seeker_date_time' => $this->permission_seeker_date_time ? \Carbon\Carbon::parse($this->permission_seeker_date_time)->format('h:i A , d M ,Y') : null,
            'permission_seeker_feedback_date_time' => $this->permission_seeker_feedback_date_time ? \Carbon\Carbon::parse($this->permission_seeker_feedback_date_time)->format('h:i A , d M ,Y') : null,
            'deny_date_time' => $this->deny_date_time ? \Carbon\Carbon::parse($this->deny_date_time)->format('h:i A , d F ,Y') : null,
            'created_at' => $this->created_at ? \Carbon\Carbon::parse($this->created_at)->format('h:i A , d M ,Y') : null,
            'updated_at' => $this->updated_at ? \Carbon\Carbon::parse($this->updated_at)->format('h:i A , d M ,Y') : null,
            'supportTicketFiles' => $this->supportTicketFiles ?? null,
            'user' => $this->user ?? '',
            'assign' => $this->assign ?? '',
            'ticketAssignBy' => $this->ticketAssignBy ?? '',
            'deny' => $this->deny ?? '',
            'cancel' => $this->cancel ?? '',
            'completed' => $this->completed ?? '',
            'permissionSeeker' => $this->permissionSeeker ?? '',
            'permissionSeekBy' => $this->permissionSeekBy ?? '',
            'supportTicketReplies' => $this->supportTicketReplies ?? '',
            'totalRow' => $this->totalRow ?? '',

            'assign_name' => $this->assign->name ?? '',
            'deny_name' => $this->deny->name ?? '',
            'cancel_name' => $this->cancel->name ?? '',
            'completed_name' => $this->completed->name ?? '',
            'permission_seeker_name' => $this->permissionSeeker->name ?? '',
            'created_name' => $this->user->name ?? '',
            'support_ticket_department_name' => $this->support_ticket_department->department_name ?? 'N/A',
        ];
    }
}