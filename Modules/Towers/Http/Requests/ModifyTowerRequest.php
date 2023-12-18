<?php

namespace Modules\Towers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyTowerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'standard_id' => ['required', 'exists:standards,id'],
            'operator_id' => ['required', 'exists:operators,id'],
            'bsn' => ['required', 'numeric'],
            'lac' => ['required', 'numeric'],
            'cell_id' => ['required', 'numeric'],
            'mnc' => ['required', 'numeric'],
            'x' => ['required', 'numeric'],
            'y' => ['required', 'numeric'],
            'band' => ['required', 'numeric'],
            'sector' => ['required', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'standard_id' => '"Стандарт"',
            'operator_id' => '"Оператор"',
            'bsn' => '"BSN"',
            'lac' => '"LAC"',
            'cell_id' => '"CELL ID"',
            'mnc' => '"MNC"',
            'x' => '"Долгота"',
            'y' => '"Широта"',
            'band' => '"Band"',
            'sector' => '"Sector"',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
