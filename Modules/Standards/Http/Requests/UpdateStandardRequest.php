<?php

namespace Modules\Standards\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStandardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:standards,name,' . $this['id']],
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
