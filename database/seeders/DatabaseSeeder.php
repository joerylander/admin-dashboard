<?php

namespace Database\Seeders;

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
        ]);

        $this->call([
            // Seed in order. If one seeder depends on another seeder, it need to seed second as it depends on the other seeders data
            ImageSeeder::class,
            BenefitSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
