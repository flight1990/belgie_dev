<?php

namespace Modules\Tests\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ConnectionTypes\Transformers\ConnectionTypeResource;
use Modules\Operators\Transformers\OperatorResource;
use Modules\Servers\Transformers\ServerResource;
use Modules\Standards\Transformers\StandardResource;
use Modules\Towers\Transformers\TowerResource;
use Modules\Users\Transformers\UserResource;

class TestResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'x' => $this->whenHas('x'),
            'y' => $this->whenHas('y'),
            'distance' => $this->whenHas('distance'),
            'max_speed_download' => $this->whenHas('max_speed_download'),
            'medium_speed_download' => $this->whenHas('medium_speed_download'),
            'max_speed_upload' => $this->whenHas('max_speed_upload'),
            'min_speed_upload' => $this->whenHas('min_speed_upload'),
            'max_ping' => $this->whenHas('max_ping'),
            'medium_ping' => $this->whenHas('medium_ping'),
            'time_start' => $this->whenHas('time_start'),
            'time_download_web_1' => $this->whenHas('time_download_web_1'),
            'time_download_web_2' => $this->whenHas('time_download_web_2'),
            'time_download_web_3' => $this->whenHas('time_download_web_3'),
            'loss_ping' => $this->whenHas('loss_ping'),
            'model_phone' => $this->whenHas('model_phone'),
            'version_os' => $this->whenHas('version_os'),
            'level_signal' => $this->whenHas('level_signal'),
            'address_site_1' => $this->whenHas('address_site_1'),
            'address_site_2' => $this->whenHas('address_site_2'),
            'address_site_3' => $this->whenHas('address_site_3'),
            'address_youtube' => $this->whenHas('address_youtube'),
            'screen_resolution' => $this->whenHas('screen_resolution'),
            'load_web_1' => $this->whenHas('load_web_1'),
            'load_web_2' => $this->whenHas('load_web_2'),
            'load_web_3' => $this->whenHas('load_web_3'),
            'data_used' => $this->whenHas('data_used'),
            'complaint' => $this->whenHas('complaint'),
            'is_room' => $this->whenHas('is_room'),
            'band' => $this->whenHas('band'),
            'sector' => $this->whenHas('sector'),
            'operators.name' => $this->whenHas('operators.name'),
            'standards.name' => $this->whenHas('standards.name'),
            'connection_types.name' => $this->whenHas('connection_types.name'),
            'servers.name' => $this->whenHas('servers.name'),
            'towers.cell_id' => $this->whenHas('towers.cell_id'),
            'created_at' => $this->whenHas('created_at', fn() => $this->resource->created_at?->format('d.m.y H:i:s')),
        ];
    }
}
