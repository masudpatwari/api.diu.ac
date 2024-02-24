<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiveMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'srcnum'            => $this->srcnum,
            'provid'            => $this->provid,
            'msg'               => $this->msg,
            'time'              => \Carbon\Carbon::parse($this->time)->format('Y-m-d h:i:s A'),
            'goipid'            => $this->goipid,
            'goipname'          => $this->goipname,
            'srcid'             => $this->srcid,
            'srcname'           => $this->srcname,
            'srclevel'          => $this->srclevel,
            'status'            => $this->status,
            'smscnum'           => $this->smscnum,
            'senttime'          => $this->senttime,
            'provider_number'   => $this->provider_number,
            'action_status'     => $this->action_status,
        ];
    }
}