<?php

namespace App\Http\Controllers;

use App\Enums\Currency;
use App\Enums\EntryType;
use App\Models\BudgetMonth;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BudgetMonthController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('budget.show', ['year' => now()->year, 'month' => now()->month]);
    }

    public function show(int $year, int $month): View
    {
        $date = CarbonImmutable::create($year, $month);

        // null when the month hasn't been started yet → the view shows the start buttons
        $budgetMonth = BudgetMonth::forMonth($date)
            ->with(['entries' => fn ($query) => $query->orderBy('category')->orderBy('description')])
            ->first();

        return view('budget.show', [
            'date' => $date,
            'budgetMonth' => $budgetMonth,
            'totals' => $budgetMonth?->totals(),
            'entriesByType' => $budgetMonth?->entries->groupBy(fn ($entry) => $entry->type->value),
            'types' => EntryType::cases(),
            'previousMonthExists' => BudgetMonth::forMonth($date->subMonth())->exists(),
        ]);
    }

    /**
     * Start a month, filled either from the templates or as a copy of the previous month.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'between:2000,2100'],
            'month' => ['required', 'integer', 'between:1,12'],
            'source' => ['required', Rule::in(['templates', 'previous'])],
        ]);

        $date = CarbonImmutable::create($validated['year'], $validated['month']);
        $redirect = redirect()->route('budget.show', ['year' => $date->year, 'month' => $date->month]);

        if (BudgetMonth::forMonth($date)->exists()) {
            return $redirect->withErrors(['month' => 'This month has already been started.']);
        }

        $previousMonth = BudgetMonth::forMonth($date->subMonth())->with('entries')->first();

        if ($validated['source'] === 'previous' && $previousMonth === null) {
            return $redirect->withErrors(['source' => 'There is no previous month to copy.']);
        }

        // Both steps succeed or neither does, so a failure can't leave a half-filled month behind
        DB::transaction(function () use ($date, $validated, $previousMonth) {
            $budgetMonth = BudgetMonth::create([
                'month' => $date,
                'currency' => $previousMonth?->currency ?? Currency::default(),
            ]);

            if ($validated['source'] === 'templates') {
                $budgetMonth->fillFromTemplates();
            } else {
                $budgetMonth->copyEntriesFrom($previousMonth);
            }
        });

        return $redirect->with('success', 'Budget for '.$date->format('F Y').' started');
    }
}
