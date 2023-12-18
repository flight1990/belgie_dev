<?php

namespace App\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'login' => ['required', 'string', 'max:191', 'unique:admin_users,login'],
            'email' => ['required', 'string', 'max:191', 'unique:admin_users,email'],
            'password' => ['required', 'string', 'min:6', 'max:20']
        ];
    }
}
