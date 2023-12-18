<?php

namespace App\JsonApi\V2\Tests;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class TestRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'x' => ['required', 'numeric'],
            'y' => ['required', 'numeric'],
            'band' => ['required', 'numeric'],
            'sector' => ['required', 'numeric'],
            'model_phone' => ['required', 'string', 'max:191'],
            'version_os' => ['required', 'string', 'max:191'],
            'level_signal' => ['required', 'string', 'max:191'],
            'distance' => ['required', 'numeric'],
            'max_speed_download' => ['required', 'numeric'],
            'medium_speed_download' => ['required', 'numeric'],
            'max_speed_upload' => ['required', 'numeric'],
            'min_speed_upload' => ['required', 'numeric'],
            'max_ping' => ['required', 'numeric'],
            'medium_ping' => ['required', 'numeric'],
            'address_site_1' => ['nullable', 'url', 'max:191'],
            'address_site_2' => ['nullable', 'url', 'max:191'],
            'address_site_3' => ['nullable', 'url', 'max:191'],
            'address_youtube' => ['nullable', 'url', 'max:191'],
            'screen_resolution' => ['required', 'string', 'max:191'],
            'data_used' => ['required', 'string', 'max:191'],
            'complaint' => ['required', 'boolean'],
            'operator_id' => ['required', 'integer', 'exists:operators,id'],
            'standard_id' => ['required', 'integer', 'exists:standards,id'],
            'connection_type_id' => ['required', 'integer', 'exists:connection_types,id'],
            'server_id' => ['required', 'integer', 'exists:servers,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'tower_id' => ['required', 'integer', 'exists:towers,id'],
            'load_web_1' => ['required', 'string', 'max:191'],
            'load_web_2' => ['required', 'string', 'max:191'],
            'load_web_3' => ['required', 'string', 'max:191'],
            'is_room' => ['required', 'boolean'],
            'time_start' => ['required', 'numeric'],
            'time_download_web_1' => ['required', 'numeric'],
            'time_download_web_2' => ['required', 'numeric'],
            'time_download_web_3' => ['required', 'numeric'],
            'loss_ping' => ['required', 'numeric'],
        ];
    }

}
