<?php

namespace Modules\ConnectionTypes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ConnectionTypeResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
        ];
    }
}
