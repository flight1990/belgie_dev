<?php

namespace Modules\Towers\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TowerResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'standard_id' => $this->whenHas('standard_id'),
            'operator_id' => $this->whenHas('operator_id'),
            'bsn' => $this->whenHas('bsn'),
            'lac' => $this->whenHas('lac'),
            'cell_id' => $this->whenHas('cell_id'),
            'mnc' => $this->whenHas('mnc'),
            'x' => $this->whenHas('x'),
            'y' => $this->whenHas('y'),
            'band' => $this->whenHas('band'),
            'sector' => $this->whenHas('sector'),
            'standards.name' => $this->whenHas('standards.name'),
            'operators.name' => $this->whenHas('operators.name'),
            'tests_count' => $this->whenHas('tests_count'),
            'created_at' => $this->whenHas('created_at', fn() => $this->resource->created_at?->format('d.m.y H:i:s')),
            'updated_at' => $this->whenHas('updated_at', fn() => $this->resource->updated_at?->format('d.m.y H:i:s')),
        ];
    }
}
