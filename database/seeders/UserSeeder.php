<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@haventwined.com',
            'password' => bcrypt('password1234'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
