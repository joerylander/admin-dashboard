<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\EntryType;
use Database\Factories\BudgetEntryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetEntry extends Model
{
    /** @use HasFactory<BudgetEntryFactory> */
    use HasFactory;

    protected $fillable = ['recurring_entry_id', 'type', 'category', 'description', 'amount', 'currency'];

    protected function casts(): array
    {
        return [
            'type' => EntryType::class,
            'amount' => 'integer',
            'currency' => Currency::class,
        ];
    }

    public function budgetMonth(): BelongsTo
    {
        return $this->belongsTo(BudgetMonth::class);
    }

    public function recurringEntry(): BelongsTo
    {
        return $this->belongsTo(RecurringEntry::class);
    }
}
