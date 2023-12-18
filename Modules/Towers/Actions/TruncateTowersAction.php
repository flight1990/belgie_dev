<?php

namespace Modules\Towers\Actions;

use Modules\Towers\Tasks\TruncateTowersTask;

class TruncateTowersAction
{
    public function run()
    {
        return app(TruncateTowersTask::class)->run();
    }
}
