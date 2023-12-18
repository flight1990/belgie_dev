<?php

namespace Modules\ConnectionTypes\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ConnectionTypesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $this->call([
            ConnectionTypeTableSeeder::class
        ]);
    }
}
