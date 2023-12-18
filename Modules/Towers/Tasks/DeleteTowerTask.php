<?php

namespace Modules\Towers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Models\Tower;

class DeleteTowerTask
{
    public function run(int $id):  Model
    {
        $tower = Tower::query()->findOrFail($id);
        $tower->delete();

        return $tower;
    }
}
