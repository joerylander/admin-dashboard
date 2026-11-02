<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\EntryType;
use App\Models\BudgetEntry;
use App\Models\BudgetMonth;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BudgetEntry>
 */
class BudgetEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'budget_month_id' => BudgetMonth::factory(),
            'type' => fake()->randomElement(EntryType::cases()),
            'category' => fake()->randomElement(['Food', 'Housing', 'Transport', 'Fun']),
            'description' => fake()->words(2, true),
            'amount' => fake()->numberBetween(100_00, 40_000_00), // 100 - 40 000 kr in öre
            'currency' => Currency::default(),
        ];
    }
}
