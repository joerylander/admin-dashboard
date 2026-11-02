<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\EntryType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 * Same fields and amount handling as a budget entry, but only recurring types are allowed.
 */
class RecurringEntryRequest extends BudgetEntryRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'type' => ['required', Rule::enum(EntryType::class)->only(EntryType::recurring())],
            'is_active' => ['boolean'],
            'apply_to_current_month' => ['boolean'],
        ];
    }

    protected function currency(): Currency
    {
        return $this->route('recurringEntry')?->currency ?? Currency::default();
    }
}
