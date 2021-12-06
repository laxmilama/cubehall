<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductPublicResources extends JsonResource
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
            'price'=> $this->total_amount,
            'currency' => $this->currency,
            'shipping_charge' => $this->shipping_charge,
            'coupon'=> $this->coupon,
            'thumbnail' => $this->thumbnail,
            'slug'=>$this->slug,
            'product_name' => $this->product_name,
            'status' => $this->status,

        ];
    }
}
