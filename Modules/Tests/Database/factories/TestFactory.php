<?php

namespace Modules\Tests\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ConnectionTypes\Models\ConnectionType;
use Modules\Operators\Models\Operator;
use Modules\Servers\Models\Server;
use Modules\Standards\Models\Standard;
use Modules\Tests\Models\Test;
use Modules\Towers\Models\Tower;
use Modules\Users\Models\User;

class TestFactory extends Factory
{
    protected $model = Test::class;

    public function definition(): array
    {
        return [
            'x' => $this->faker->randomFloat(2, 20, 23),
            'y' => $this->faker->randomFloat(2, 50, 54),
            'distance' => $this->faker->randomFloat(2, 0, 100),
            'max_speed_download' => $this->faker->randomFloat(2, 0, 100),
            'medium_speed_download' => $this->faker->randomFloat(2, 0, 100),
            'max_speed_upload' => $this->faker->randomFloat(2, 0, 100),
            'min_speed_upload' => $this->faker->randomFloat(2, 0, 100),
            'max_ping' => $this->faker->randomFloat(2, 0, 200),
            'medium_ping' => $this->faker->randomFloat(2, 0, 200),
            'time_start' => $this->faker->randomFloat(2, 0, 200),
            'time_download_web_1' => $this->faker->randomFloat(2, 0, 200),
            'time_download_web_2' => $this->faker->randomFloat(2, 0, 200),
            'time_download_web_3' => $this->faker->randomFloat(2, 0, 200),
            'loss_ping' => $this->faker->randomFloat(2, 0, 200),
            'model_phone'=> $this->faker->phoneNumber,
            'version_os' => $this->faker->word,
            'level_signal' => rand(-100, 100),
            'address_site_1' => $this->faker->url,
            'address_site_2' => $this->faker->url,
            'address_site_3' => $this->faker->url,
            'address_youtube' => $this->faker->url,
            'screen_resolution' => 'automatic',
            'load_web_1' => rand(-100, 100),
            'load_web_2' => rand(-100, 100),
            'load_web_3' => rand(-100, 100),
            'data_used' => 480,
            'complaint' => $this->faker->boolean,
            'is_room' => $this->faker->boolean,
            'operator_id' => Operator::query()->inRandomOrder()->first()->id,
            'standard_id' => Standard::query()->inRandomOrder()->first()->id,
            'connection_type_id' => ConnectionType::query()->inRandomOrder()->first()->id,
            'server_id' => Server::query()->inRandomOrder()->first()->id,
            'tower_id' => Tower::query()->inRandomOrder()->first()->id,
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'band' => rand(1200, 1800),
            'sector' => rand(1,5)
        ];
    }
}

