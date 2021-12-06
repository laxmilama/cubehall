<?php

namespace App\Http\Resources;
use App\Http\Resources\ProductMetaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            // 'id' => $this->id,
            'name'=> $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'commission' => $this->commission,
            'customization' =>$this->customization,
            'custom_message'=>$this->custom_message,

            'metas'=> ProductMetaResource::collection($this->metas)

        ];
    }
}
