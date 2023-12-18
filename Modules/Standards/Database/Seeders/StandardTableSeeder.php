<?php

namespace Modules\Standards\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Standards\Models\Standard;

class StandardTableSeeder extends Seeder
{
    public function run(): void
    {
        $standards = [
            [
                'id' => 1,
                'name' => 'GSM',
            ],
            [
                'id' => 2,
                'name' => 'UMTS',
            ],
            [
                'id' => 3,
                'name' => 'LTE',
            ],
            [
                'id' => 8,
                'name' => '5G',
            ]
        ];

        foreach ($standards as $standard) {
            Standard::create($standard);
        }
    }
}
