<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\EntryType;
use Carbon\CarbonInterface;
use Database\Factories\BudgetMonthFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static> forMonth(\Carbon\CarbonInterface $date)
 */
class BudgetMonth extends Model
{
    /** @use HasFactory<BudgetMonthFactory> */
    use HasFactory;

    protected $fillable = ['month', 'currency'];

    protected function casts(): array
    {
        return [
            'month' => 'date',
            'currency' => Currency::class,
        ];
    }

    public function entries(): HasMany
    {
        return $this->hasMany(BudgetEntry::class);
    }

    /**
     * BudgetMonth::forMonth($date) - the row for the month $date falls in.
     */
    #[Scope]
    protected function forMonth(Builder $query, CarbonInterface $date): Builder
    {
        return $query->whereDate('month', $date->copy()->startOfMonth());
    }

    /**
     * Fill the month with every active template's current values.
     */
    public function fillFromTemplates(): void
    {
        $templates = RecurringEntry::active()->get();

        $this->entries()->createMany($templates->map(fn (RecurringEntry $template) => [
            'recurring_entry_id' => $template->id,
            'type' => $template->type,
            'category' => $template->category,
            'description' => $template->description,
            'amount' => $template->amount,
            'currency' => $template->currency,
        ]));
    }

    /**
     * Copy every entry of another month exactly, including one-off expenses.
     */
    public function copyEntriesFrom(BudgetMonth $source): void
    {
        $this->entries()->createMany($source->entries->map(fn (BudgetEntry $entry) => $entry->only([
            'recurring_entry_id', 'type', 'category', 'description', 'amount', 'currency',
        ])));
    }

    /**
     * Sums per type plus the balance, all in minor units.
     * Uses the already loaded entries, so it costs no extra query.
     *
     * @return array{income: int, fixed_costs: int, expenses: int, costs: int, balance: int}
     */
    public function totals(): array
    {
        $sumOf = fn (EntryType $type) => (int) $this->entries->where('type', $type)->sum('amount');

        $income = $sumOf(EntryType::Income);
        $fixedCosts = $sumOf(EntryType::FixedCost);
        $expenses = $sumOf(EntryType::Expense);

        return [
            'income' => $income,
            'fixed_costs' => $fixedCosts,
            'expenses' => $expenses,
            'costs' => $fixedCosts + $expenses,
            'balance' => $income - $fixedCosts - $expenses,
        ];
    }
}
