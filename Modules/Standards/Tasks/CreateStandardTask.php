<?php

namespace Modules\Standards\Tasks;
use Modules\Standards\Models\Standard;

class CreateStandardTask
{
    public function run(array $payload)
    {
        return Standard::create($payload);
    }
}
