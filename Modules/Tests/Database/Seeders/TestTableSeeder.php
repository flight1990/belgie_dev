<?php

namespace Modules\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tests\Models\Test;

class TestTableSeeder extends Seeder
{
    public function run(): void
    {
        Test::factory(100)->create();
    }
}
