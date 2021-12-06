<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParlorHistoryResources extends JsonResource
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
            'name'=> $this->title,
            'slug' => $this->slug,
            'thumb' => '/images/parlor/small/' . $this->cover,
            'type' => $this->type
        ];
    }
}
