<?php

namespace Modules\Tests\Database\Seeders;

use Illuminate\Database\Seeder;

class TestsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TestTableSeeder::class
        ]);
    }
}
