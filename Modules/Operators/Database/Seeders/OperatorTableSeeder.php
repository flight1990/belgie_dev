<?php

namespace Modules\Operators\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Operators\Models\Operator;

class OperatorTableSeeder extends Seeder
{
    public function run(): void
    {
        $operators = [
            [
                'name' => 'MTS.BY',
                'provider' => 'MTS',
                'mnc' => 2
            ],
            [
                'name' => 'A1.BY',
                'provider' => 'A1',
                'mnc' => 1
            ],
            [
                'name' => 'Life:).BY',
                'provider' => 'Life:)',
                'mnc' => 4
            ]
        ];

        foreach ($operators as $operator) {
            Operator::create($operator);
        }
    }
}
