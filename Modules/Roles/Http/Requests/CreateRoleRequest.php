<?php

namespace Modules\Roles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'users' => ['nullable', 'array'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '"Название"',
            'permissions' => '"Права"',
            'users' => '"Пользователи"',
        ];
    }


    public function authorize(): bool
    {
        return true;
    }
}
