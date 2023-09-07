<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'student_id'    => $this->student_id,
            'student_name'  => $this->student_name,
            'reg_no'        => $this->reg_no,
            'old_seat'      => $this->oldSeat->bed_type,
            'hostel'        => $this->newSeat->hostel->name,
            'room'          => $this->newSeat->room_number,
            'bed_type'      => $this->bed_type,
            'status'        => $this->status,
            'shift_date'    => Carbon::parse($this->shift_date)->format('d M, Y'),
        ];
    }
}
