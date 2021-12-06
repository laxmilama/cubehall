<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryProductMetaDataResources extends JsonResource
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
            "title"=> $this->title,
            'thumbnail' => $this->thumbnail,
            'price' => $this->price,
            'currency' => $this->currency,
            'availability' => $this->availability
        ];
    }
}
