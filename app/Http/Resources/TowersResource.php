<?php

namespace App\Http\Resources;

use App\Models\Operators;
use App\Models\Standards;
use Illuminate\Http\Resources\Json\JsonResource;

class TowersResource extends JsonResource
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
            "standard" => $this->standard->name ?? null,
            "operator" => $this->operator->name ?? null,
            "bsn" => $this->bsn,
            "lac" => $this->lac,
            "cell_id" => $this->cell_id,
            "mnc" => $this->mnc,
            "y" => $this->y,
            "x" => $this->x,
            "band" => $this->band,
            "sector" => $this->sector
        ];
    }
}
