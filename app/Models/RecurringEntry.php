<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\EntryType;
use Database\Factories\RecurringEntryFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A template for income or a fixed cost that repeats every month.
 * Its values are copied into a month when the month is started from templates.
 * @method static \Illuminate\Database\Eloquent\Builder<static> active()
 */
class RecurringEntry extends Model
{
    /** @use HasFactory<RecurringEntryFactory> */
    use HasFactory;

    protected $fillable = ['type', 'category', 'description', 'amount', 'currency', 'is_active'];

    protected function casts(): array
    {
        return [
            'type' => EntryType::class,
            'amount' => 'integer',
            'currency' => Currency::class,
            'is_active' => 'boolean',
        ];
    }

    public function budgetEntries(): HasMany
    {
        return $this->hasMany(BudgetEntry::class);
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
