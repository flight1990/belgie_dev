<?php

namespace App\JsonApi\V2\Operators;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class OperatorRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $model = $this->model();

        $uniqueName = Rule::unique('operators', 'name');
        $uniqueProvider = Rule::unique('operators', 'provider');

        if ($model) {
            $uniqueName->ignoreModel($model);
            $uniqueProvider->ignoreModel($model);
        }

        return [
            'name' => ['required', 'string', 'max:191', $uniqueName],
            'provider' => ['required', 'string', 'max:191', $uniqueProvider],
            'mnc' => ['required', 'integer'],
        ];
    }

}
