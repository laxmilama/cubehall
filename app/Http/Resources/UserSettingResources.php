<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingResources extends JsonResource
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
            'id' => $this->id,
            'profile_image' => $this->profile_image,
            'kyc' => $this->kyc,
            'bio' =>$this->bio,
            'number' =>$this->number,
            'slug' => $this->slug,
            'name' => $this->name,
            'email' =>$this->email,
        ];
    }
}
