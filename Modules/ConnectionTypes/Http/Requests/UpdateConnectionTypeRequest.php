<?php

namespace Modules\ConnectionTypes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConnectionTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:connection_types,name,' . $this['id']],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '"Название"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
