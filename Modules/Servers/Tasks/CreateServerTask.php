<?php

namespace Modules\Servers\Tasks;
use Modules\Servers\Models\Server;

class CreateServerTask
{
    public function run(array $payload)
    {
        return Server::create($payload);
    }
}
