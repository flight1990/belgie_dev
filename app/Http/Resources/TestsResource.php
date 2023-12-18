<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestsResource extends JsonResource
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
            "test" => $this->id,
            "x" => $this->x,
            "y" => $this->y,
            "created_at" => $this->created_at->format('d.m.Y H:i:s'),
            "model_phone" => $this->model_phone,
            "version_os" => $this->version_os,
            "level_signal" => $this->level_signal,
            "distance" => $this->distance,
            "max_speed_download" => $this->max_speed_download,
            "medium_speed_download" => $this->medium_speed_download,
            "max_speed_upload" => $this->max_speed_upload,
            "min_speed_upload" => $this->min_speed_upload,
            "max_ping" => $this->max_ping,
            "medium_ping" => $this->medium_ping,
            "loss_ping" => $this->loss_ping,
            "address_site_1" => $this->address_site_1,
            "address_site_2" => $this->address_site_2,
            "address_site_3" => $this->address_site_3,
            "time_download_web_1" => $this->time_download_web_1,
            "time_download_web_2" => $this->time_download_web_2,
            "time_download_web_3" => $this->time_download_web_3,
            "load_web_1" => $this->load_web_1,
            "load_web_2" => $this->load_web_2,
            "load_web_3" => $this->load_web_3,
            "address_youtube" => $this->address_youtube,
            "screen_resolution" => $this->screen_resolution,
            "time_start" => $this->time_start,
            "data_used" => $this->data_used,
            "complaint" => $this->complaint,
            "is_room" => $this->is_room,
            "operator" => $this->operator->name ?? '-',
            "provider" => $this->operator->provider ?? '-',
            "standard" => $this->standard->name ?? '-',
            "connection_type" => $this->connection_type->name ?? '-',
            "server" => $this->server->name ?? '-',
            "user" => $this->user->name ?? '-',
            "tower" => new TowersResource($this->tower),
        ];
    }
}
