<?php

namespace Modules\ConnectionTypes\Tasks;
use Modules\ConnectionTypes\Models\ConnectionType;

class CreateConnectionTypeTask
{
    public function run(array $payload)
    {
        return ConnectionType::create($payload);
    }
}
