<?php

namespace Modules\Profile\Actions;

use Modules\Profile\Tasks\UpdateProfileTask;

class UpdateProfileAction
{
    public function run(array $data, int $id)
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return app(UpdateProfileTask::class)->run($data, $id);
    }
}
