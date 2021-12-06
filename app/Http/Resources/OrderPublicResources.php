<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderPublicResources extends JsonResource
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
            'total_amount'=> $this->total_amount,
            'currency' => $this->currency,
            'identifier' => $this->slug,
            'orders'=> OrderProductPublicResources::collection($this->metas),
            'created_at'=> $this->created_at,

        ];
    }
}
