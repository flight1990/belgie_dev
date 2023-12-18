<?php

namespace Modules\Towers\Database\Seeders;

use Illuminate\Database\Seeder;

class TowersDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TowerTableSeeder::class
        ]);
    }
}
