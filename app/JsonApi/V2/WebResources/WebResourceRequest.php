<?php

namespace App\JsonApi\V2\WebResources;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class WebResourceRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'address_site_1' => ['required', 'url', 'max:191'],
            'address_site_2' => ['required', 'url', 'max:191'],
            'address_site_3' => ['required', 'url', 'max:191'],
            'address_video' => ['required', 'url', 'max:191'],
            'active' => ['required', 'boolean'],
        ];
    }

}
