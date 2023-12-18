<?php

namespace App\JsonApi\V2\Towers;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class TowerRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'standard_id' => ['required', 'integer', 'exists:standards,id'],
            'operator_id' => ['required', 'integer', 'exists:operators,id'],
            'bsn' => ['required', 'integer', 'min:1'],
            'lac' => ['required', 'integer', 'min:1'],
            'cell_id' => ['required', 'integer', 'min:1'],
            'mnc' => ['required', 'integer', 'min:1'],
            'y' => ['required', 'numeric'],
            'x' => ['required', 'numeric'],
            'band' => ['required', 'numeric'],
            'sector' => ['required', 'numeric'],
        ];
    }

}
