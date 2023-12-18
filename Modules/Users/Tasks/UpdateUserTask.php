<?php

namespace Modules\Users\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class UpdateUserTask
{
    public function run(array $data, int $id): Model
    {
        $user = User::query()->findOrFail($id);

        $user->update($data);

        return $user;
    }
}
