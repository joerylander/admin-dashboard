<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'title' => fake()->jobTitle(),
            'testimonial' => fake()->paragraph(),
            'image_id' => Image::where('file_path', 'like', 'images/profiles/%')->inRandomOrder()->first()?->id
        ];
    }
}
