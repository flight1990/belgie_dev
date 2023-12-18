<?php

namespace Modules\AdminUsers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin_users,email,'.$this['id']],
            'login' => ['required', 'string', 'max:255', 'unique:admin_users,login,'.$this['id']],
            'roles' => ['nullable', 'array'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '"Ф.И.О"',
            'email' => '"Email"',
            'login' => '"Login"',
            'roles' => '"Роли"',
            'password' => '"Пароль"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
