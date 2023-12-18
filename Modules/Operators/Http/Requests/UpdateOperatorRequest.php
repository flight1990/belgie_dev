<?php

namespace Modules\Operators\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperatorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:operators,name,' . $this['id']],
            'provider' => ['required', 'string', 'max:255'],
            'mnc' => ['required', 'integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '"Название"',
            'provider' => '"Провайдер"',
            'mnc' => '"MNC"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
