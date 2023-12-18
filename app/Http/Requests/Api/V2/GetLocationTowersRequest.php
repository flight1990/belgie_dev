<?php

namespace App\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class GetLocationTowersRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'x' => ['required'],
            'y' => ['required'],
            'distance' => ['required']
        ];
    }
}
