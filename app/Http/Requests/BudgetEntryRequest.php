<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\EntryType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BudgetEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Routes are already behind the 'auth' middleware, so any logged-in user may manage the budget
        return true;
    }

    /**
     * Normalize input before the rules run: "1 250,50" → "1250.50".
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('amount')) {
            $amount = preg_replace('/\s+/u', '', (string) $this->input('amount')); // also removes non-breaking spaces
            $this->merge(['amount' => str_replace(',', '.', $amount)]);
        }

        if ($this->filled('category')) {
            $this->merge(['category' => Str::ucfirst(trim($this->input('category')))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(EntryType::class)],
            'category' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'string', 'regex:'.$this->currency()->inputPattern()],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'amount.regex' => 'The amount must be a positive number with at most '.$this->currency()->decimals().' decimals, e.g. 1 250,50.',
        ];
    }

    /**
     * The validated data, with the amount converted to minor units (öre) for storage.
     *
     * @return array{type: string, category: string, description: string, amount: int}
     */
    public function entryAttributes(): array
    {
        return [
            ...$this->safe()->only(['type', 'category', 'description']),
            'amount' => $this->currency()->toMinorUnits($this->validated('amount')),
        ];
    }

    /**
     * The currency the amount is entered in: the month's or the existing entry's.
     */
    protected function currency(): Currency
    {
        return $this->route('budgetMonth')?->currency
            ?? $this->route('budgetEntry')?->currency
            ?? Currency::default();
    }
}
