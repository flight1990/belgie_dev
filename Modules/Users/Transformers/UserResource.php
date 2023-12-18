<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'email' => $this->whenHas('email'),
            'login' => $this->whenHas('login'),
            'hash' => $this->whenHas('hash'),
            'tests_count' => $this->whenHas('tests_count'),
            'created_at' => $this->whenHas('created_at', fn() => $this->resource->created_at?->format('d.m.Y H:i:s')),
            'updated_at' => $this->whenHas('updated_at', fn() => $this->resource->created_at?->format('d.m.Y H:i:s')),
        ];
    }
}
