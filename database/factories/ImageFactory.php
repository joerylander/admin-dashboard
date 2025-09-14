<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_path' => 'images/' . fake()->uuid() . '.jpg',
            'original_filename' => fake()->word() . '.jpg', 
            'mime_type' => fake()->randomElement(['image/jpeg', 'image/png', 'image/gif']),
            'size' => fake()->numberBetween(1000, 5000000), // 1KB to 5MB
        ];
    }
}
