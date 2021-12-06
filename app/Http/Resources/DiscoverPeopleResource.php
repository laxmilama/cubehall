<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscoverPeopleResource extends JsonResource
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
            'name' => $this->firstName($this->name),
            'handle' => $this->slug,
            'description' => $this->meta_description,
            'followers' => $this->followers_count,
            'is_followed' => $this->is_followed,
            'profile_image' => $this->profile_image,
            'showoffs' => ShowoffThumbnailResource::collection($this->fiveShowoffs),
        ]; 
    }


    function firstName($name)
    {
        $nameArray = explode(" ", $name);
        return $nameArray[0];
    }
}
