<?php

namespace Modules\Towers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Models\Tower;

class UpdateTowerTask
{
    public function run(array $payload, int $id): Model
    {
        $tower = Tower::query()->findOrFail($id);
        $tower->update($payload);

        return $tower;
    }
}
