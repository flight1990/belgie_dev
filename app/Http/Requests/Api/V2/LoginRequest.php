<?php

namespace App\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:191'],
            'password' => ['required', 'string']
        ];
    }
}
