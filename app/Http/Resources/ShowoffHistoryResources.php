<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowoffHistoryResources extends JsonResource
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
            'thumb' => '/images/showoff/small/' . $this->media,
            'type' => $this->type,
        ];
    }
}