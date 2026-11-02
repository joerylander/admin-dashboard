<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\BudgetMonth;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BudgetMonth>
 */
class BudgetMonthFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'month' => now()->startOfMonth(),
            'currency' => Currency::default(),
        ];
    }
}
