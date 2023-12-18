<?php

namespace Modules\Servers\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Servers\Models\Server;

class ServerTableSeeder extends Seeder
{
    public function run(): void
    {
        $servers = [
            [
                'id' => 1,
                'name' => '212.98.179.84',
                'active' => false
            ],
            [
                'id' => 5,
                'name' => '178.124.138.34',
                'active' => false
            ],
            [
                'id' => 6,
                'name' => '195.50.11.18',
                'active' => false
            ],
            [
                'id' => 9,
                'name' => '82.209.230.71',
                'active' => false
            ],
            [
                'id' => 10,
                'name' => '93.85.84.242',
                'active' => true
            ]
        ];

        foreach ($servers as $server) {
            Server::create($server);
        }
    }
}
