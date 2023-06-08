<?php

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
            UserSeeder::class,
            EventsSeeder::class,
            ContactSeeder::class,
            GroupSeeder::class,
            MessageSeeder::class
        ]);
    }
}
