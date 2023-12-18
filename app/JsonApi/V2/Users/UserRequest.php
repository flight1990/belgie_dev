<?php

namespace App\JsonApi\V2\Users;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class UserRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $model = $this->model();

        $uniqueHash = Rule::unique('users', 'hash');
        $uniqueLogin = Rule::unique('users', 'login');

        if ($model) {
            $uniqueHash->ignoreModel($model);
            $uniqueLogin->ignoreModel($model);
        }

        return [
            'login' => ['nullable', 'string', 'max:191', $uniqueLogin],
            'password' => ['nullable', 'string', 'max:100'],
            'hash' => [$model ? 'nullable' : 'required', 'string', $uniqueHash]
        ];
    }
}
