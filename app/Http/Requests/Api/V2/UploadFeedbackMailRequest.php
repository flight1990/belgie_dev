<?php

namespace App\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class UploadFeedbackMailRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => ['required', 'email', 'max:191'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ];
    }
}
