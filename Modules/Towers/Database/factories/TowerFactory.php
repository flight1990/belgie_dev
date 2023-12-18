<?php

namespace Modules\Towers\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Operators\Models\Operator;
use Modules\Standards\Models\Standard;
use Modules\Towers\Models\Tower;

class TowerFactory extends Factory
{
    protected $model = Tower::class;

    public function definition(): array
    {
        return [
            'operator_id' => Operator::query()->inRandomOrder()->first()->id,
            'standard_id' => Standard::query()->inRandomOrder()->first()->id,
            'x' => $this->faker->randomFloat(2, 20, 23),
            'y' => $this->faker->randomFloat(2, 50, 54),
            'band' => rand(1200, 1800),
            'sector' => rand(1,5),
            'bsn' => $this->faker->randomNumber(8),
            'lac' => $this->faker->randomNumber(4),
            'cell_id' => $this->faker->randomNumber(4),
            'mnc' => $this->faker->randomNumber(3),
        ];
    }
}

