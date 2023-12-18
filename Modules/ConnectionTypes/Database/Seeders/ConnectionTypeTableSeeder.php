<?php

namespace Modules\ConnectionTypes\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ConnectionTypes\Models\ConnectionType;

class ConnectionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $types = [
            [
                'name' => '2G',
            ],
            [
                'name' => '3G',
            ],
            [
                'name' => '4G',
            ],
            [
                'name' => '5G',
            ]
        ];

        foreach ($types as $type) {
            ConnectionType::create($type);
        }
    }
}
