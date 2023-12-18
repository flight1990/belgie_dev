<?php

namespace Modules\Servers\Tasks;

use Illuminate\Database\Eloquent\Collection;
use Modules\Servers\Models\Server;

class GetServersTask
{
    public function run(): Collection
    {
        return Server::query()
            ->select(['id', 'name', 'active'])
            ->get();
    }
}
