<?php

namespace Modules\Servers\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'active' => $this->whenHas('active'),
        ];
    }
}
