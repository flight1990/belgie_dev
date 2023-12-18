<?php

namespace Modules\Users\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class FindUserByIdTask
{
    public function run(int $id): Model
    {
        return User::query()
            ->findOrFail($id);
    }
}
