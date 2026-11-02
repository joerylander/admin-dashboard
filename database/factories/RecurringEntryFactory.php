<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\EntryType;
use App\Models\RecurringEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecurringEntry>
 */
class RecurringEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(EntryType::recurring()),
            'category' => fake()->randomElement(['Salary', 'Housing', 'Insurance', 'Loans']),
            'description' => fake()->words(2, true),
            'amount' => fake()->numberBetween(100_00, 40_000_00), // 100 - 40 000 kr in öre
            'currency' => Currency::default(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
