<?php

namespace Modules\Towers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Towers\Models\Tower;

class CreateTowerTask
{
    public function run(array $payload): Model
    {
        return Tower::create($payload);
    }
}
