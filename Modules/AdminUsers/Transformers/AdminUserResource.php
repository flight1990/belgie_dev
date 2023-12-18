<?php

namespace Modules\AdminUsers\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'email' => $this->whenHas('email'),
            'login' => $this->whenHas('login'),
            'email_verified_at' => $this->whenHas('email_verified_at', fn() => $this->resource->created_at?->format('d.m.Y H:i:s')),
            'created_at' => $this->whenHas('created_at', fn() => $this->resource->created_at?->format('d.m.Y H:i:s')),
            'updated_at' => $this->whenHas('updated_at', fn() => $this->resource->created_at?->format('d.m.Y H:i:s')),
        ];
    }
}
