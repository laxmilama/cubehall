<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResources extends JsonResource
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
            'type' => $this->type,
            'notifiable_id' => $this->notifiable_id,
            'data' => json_decode($this->data),
            'read_at' => $this->read_at,
            'created_at' => $this->created_at
        ];
    }
}
