<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\SystemSetting;

class SystemSettingDetailsResource extends JsonResource
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
            'key' => $this->key,
            'value' => $this->value,
            'last_update' => datetime_format($this->updated_at),
            'created_by' => new EmployeeShortDetailsResource($this->relCreatedBy),
            'updated_by' => new EmployeeShortDetailsResource($this->relUpdatedBy),
            'history' => SystemSettingHistoryResource::collection(SystemSetting::where('key', $this->key)->orderBy('id', 'desc')->onlyTrashed()->get())
        ];
    }
}