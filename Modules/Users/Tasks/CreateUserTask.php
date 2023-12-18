<?php

namespace Modules\Users\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class CreateUserTask
{
    public function run(array $data): Model
    {
        $data['password'] = bcrypt($data['password']);

        return User::create($data);
    }
}
