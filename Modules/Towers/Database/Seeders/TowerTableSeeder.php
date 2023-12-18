<?php

namespace Modules\Towers\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Towers\Models\Tower;

class TowerTableSeeder extends Seeder
{
    public function run(): void
    {
        Tower::factory(500)->create();
    }
}
