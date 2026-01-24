<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Location::create([
            'name' => 'Panetto Belgrano',
            'slug' => 'panetto-belgrano',
        ]);

        Location::create([
            'name' => 'Panetto Plaza',
            'slug' => 'panetto-plaza',
        ]);
    }
}
