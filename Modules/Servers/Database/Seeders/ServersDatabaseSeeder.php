<?php

namespace Modules\Servers\Database\Seeders;

use Illuminate\Database\Seeder;

class ServersDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServerTableSeeder::class
        ]);
    }
}
