<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductHistoryResources extends JsonResource
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
            'name'=> $this->name,
            'slug' => $this->slug,
            'thumb' => '/images/product/small/' . $this->meta->thumbnail,
            'type' => $this->type,
        ];
    }
}
