<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponShopperResource extends JsonResource
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
            'name'=> $this->firstName($this->name),
            'thumb' => '/images/profile/thumb/' . $this->profile_image,
        ];
    }

    function firstName($name){
        $nameArray = explode(" ", $name);
        return $nameArray[0];
    }
}
