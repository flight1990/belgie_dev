<?php

namespace App\JsonApi\V2\Standards;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class StandardRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $model = $this->model();

        $uniqueName = Rule::unique('standards', 'name');

        if ($model) {
            $uniqueName->ignoreModel($model);
        }

        return [
            'name' => ['required', 'string', 'max:191', $uniqueName],
        ];
    }

}
