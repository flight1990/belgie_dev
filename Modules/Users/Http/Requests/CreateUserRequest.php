<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'login' => ['required', 'string', 'max:255', 'unique:users,login'],
            'hash' => ['required', 'string', 'max:255', 'unique:users,hash'],
            'roles' => ['nullable', 'array'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
