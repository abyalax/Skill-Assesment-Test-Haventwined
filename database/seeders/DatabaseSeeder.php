<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\EventsSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {

        $this->call([
            CompanySeeder::class,
            EventsSeeder::class,
            UserSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
