<?php

namespace Modules\Operators\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OperatorResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'provider' => $this->whenHas('provider'),
            'mnc' => $this->whenHas('mnc'),
        ];
    }
}
