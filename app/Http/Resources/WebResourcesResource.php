<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebResourcesResource extends JsonResource
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
            'address_site_1' => $this->address_site_1,
            'address_site_2' =>  $this->address_site_2,
            'address_site_3' =>  $this->address_site_3,
            'address_video' =>  $this->address_video,
        ];
    }
}
