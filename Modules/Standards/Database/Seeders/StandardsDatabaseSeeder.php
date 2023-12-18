<?php

namespace Modules\Standards\Database\Seeders;

use Illuminate\Database\Seeder;

class StandardsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StandardTableSeeder::class
        ]);
    }
}
