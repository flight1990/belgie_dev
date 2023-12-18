<?php

namespace Modules\Towers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportTowerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file'],
            'truncate' => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'file' => '"Файл"',
            'truncate' => '"Очистить данные перед импортом"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
