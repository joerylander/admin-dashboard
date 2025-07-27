<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ninja;

class NinjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Executes when running a migration, using the factory file as reference on fake records to populate database with
        // This need to be called inside DatabaseSeeder file
        Ninja::factory()->count(50)->create();
    }
}
