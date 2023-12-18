<?php

namespace Modules\Servers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Servers\Models\Server;

class UpdateServerTask
{
    public function run(array $payload, int $id): Model
    {
        $server = Server::query()->findOrFail($id);
        $server->update($payload);

        return $server;
    }
}
