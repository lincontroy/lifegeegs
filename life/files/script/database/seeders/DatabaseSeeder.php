<?php

namespace Database\Seeders;

use Database\Seeders\UserTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            PaymentGatewaySeeder::class,
            PlanSeeder::class,
            CurrencySeeder::class,
            OptionSeeder::class,
            TermSeeder::class,
        ]);
    }
}
