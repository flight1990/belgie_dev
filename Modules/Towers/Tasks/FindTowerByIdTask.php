<?php

namespace Modules\Towers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Models\Tower;

class FindTowerByIdTask
{
    public function run(int $id): Model
    {
        return Tower::query()->findOrFail($id);
    }
}
