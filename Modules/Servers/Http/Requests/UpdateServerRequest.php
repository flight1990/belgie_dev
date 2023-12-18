<?php

namespace Modules\Servers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:servers,name,' . $this['id']],
            'active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '"Название"',
            'active' => '"Состояние"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
