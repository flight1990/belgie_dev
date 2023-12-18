<?php

namespace Modules\Servers\Tasks;

use Illuminate\Database\Eloquent\Model;
use Modules\Servers\Models\Server;

class DeleteServerTask
{
    public function run(int $id): Model
    {
        $server = Server::query()->findOrFail($id);
        $server->delete();

        return $server;
    }
}
