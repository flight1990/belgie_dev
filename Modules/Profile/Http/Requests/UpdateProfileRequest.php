<?php

namespace Modules\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '"Ф.И.О"',
            'email' => '"Email"',
            'password' => '"Пароль"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
