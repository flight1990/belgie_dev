<?php

namespace App\JsonApi\V2\AdminUsers;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class AdminUserRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $model = $this->model();

        $uniqueLogin = Rule::unique('admin_users', 'login');
        $uniqueEmail = Rule::unique('admin_users', 'email');

        if ($model) {
            $uniqueLogin->ignoreModel($model);
            $uniqueEmail->ignoreModel($model);
        }

        return [
            'name' => ['required', 'string', 'max:191'],
            'login' => ['required', 'string', 'max:191', $uniqueLogin],
            'email' => ['required', 'email', 'max:191', $uniqueEmail],
            'password' => [$model ? 'nullable' : 'required', 'string', 'max:100'],
        ];
    }

}
