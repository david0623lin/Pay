<?php

namespace Database\Seeders;

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
        $this->call(MerchantsSeeder::class);
        $this->call(PaymentsSeeder::class);
        $this->call(PepaySeeder::class);
    }
}
