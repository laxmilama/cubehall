<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicReviewsResources extends JsonResource
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
            'review' => $this->review,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'writer_name' => $this->firstName($this->writer->name),
            'profile_image' => $this->writer->profile_image,
        ];
    }

    function firstName($name)
    {
        $nameArray = explode(" ", $name);
        return $nameArray[0];
    }
}
