<?php

namespace App\JsonApi\V2\ConnectionTypes;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class ConnectionTypeRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $model = $this->model();

        $uniqueName = Rule::unique('connection_types', 'name');

        if ($model) {
            $uniqueName->ignoreModel($model);
        }

        return [
            'name' => ['required', 'string', 'max:191', $uniqueName],
        ];
    }

}
