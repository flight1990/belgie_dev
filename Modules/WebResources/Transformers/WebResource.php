<?php

namespace Modules\WebResources\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class WebResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'address_site_1' => $this->whenHas('address_site_1'),
            'address_site_2' => $this->whenHas('address_site_2'),
            'address_site_3' => $this->whenHas('address_site_3'),
            'address_video' => $this->whenHas('address_video'),
            'active' => $this->whenHas('active'),
        ];
    }
}
