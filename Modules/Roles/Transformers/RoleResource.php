<?php

namespace Modules\Roles\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'guard_name' => $this->whenHas('guard_name'),
            'created_at' => $this->whenHas('created_at', fn() => $this->resource->created_at?->format('d.m.Y H:i:s')),
            'updated_at' => $this->whenHas('updated_at', fn() => $this->resource->created_at?->format('d.m.Y H:i:s')),
        ];
    }
}
