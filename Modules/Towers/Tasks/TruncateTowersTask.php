<?php

namespace Modules\Towers\Tasks;
use Modules\Towers\Models\Tower;

class TruncateTowersTask
{
    public function run()
    {
        return Tower::truncate();
    }
}
