<?php

namespace Modules\WebResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebResourceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address_site_1' => ['required', 'url', 'max:255'],
            'address_site_2' => ['required', 'url', 'max:255'],
            'address_site_3' => ['required', 'url', 'max:255'],
            'address_video' => ['required', 'string', 'max:255'],
            'active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'address_site_1' => '"Cсылка на сайт 1"',
            'address_site_2' => '"Cсылка на сайт 2"',
            'address_site_3' => '"Cсылка на сайт 3"',
            'address_video' => '"Cсылка на видео"',
            'active' => '"Состояние"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
