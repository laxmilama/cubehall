<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryProductResources extends JsonResource
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
            'created_at' =>$this->created_at,
            'item_id' => $this->item_id,
            'type' => $this->type,
            "visits" => $this->visits,
            'product' => new HistoryProductDataResources($this->product),
        ];
    }
}
