<?php

namespace Modules\Profile\Tasks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\User;

class UpdateProfileTask
{
    public function run(array $data, int $id): Model|Collection|Builder|array|null
    {
        $user = User::query()->findOrFail($id);

        $user->update($data);

        return $user;
    }
}
