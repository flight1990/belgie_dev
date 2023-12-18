<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this['id']],
            'login' => ['required', 'string', 'max:255', 'unique:users,login,'.$this['id']],
            'hash' => ['required', 'string', 'max:255', 'unique:users,hash,'.$this['id']],
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
            'hash' => '"Hash"',
            'roles' => '"Роли"',
            'password' => '"Пароль"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
