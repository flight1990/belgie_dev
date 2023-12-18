<?php

namespace Modules\WebResources\Database\Seeders;

use Illuminate\Database\Seeder;

class WebResourcesDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WebResourceTableSeeder::class
        ]);
    }
}
