<?php

namespace App\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class GetStartTowerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'x' => ['required', 'numeric'],
            'y' => ['required', 'numeric'],
            'mnc' => ['required', 'numeric'],
            'standard_id' => ['required', 'integer', 'exists:standards,id']
        ];
    }
}
