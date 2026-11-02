<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetEntryRequest;
use App\Models\BudgetEntry;
use App\Models\BudgetMonth;
use Illuminate\Http\RedirectResponse;

class BudgetEntryController extends Controller
{
    public function store(BudgetEntryRequest $request, BudgetMonth $budgetMonth): RedirectResponse
    {
        $budgetMonth->entries()->create([
            ...$request->entryAttributes(),
            'currency' => $budgetMonth->currency, // Entries always use their month's currency
        ]);

        return $this->backToMonth($budgetMonth)->with('success', 'Entry added');
    }

    /**
     * Only changes this month's entry; the template it came from stays as it is.
     */
    public function update(BudgetEntryRequest $request, BudgetEntry $budgetEntry): RedirectResponse
    {
        $budgetEntry->update($request->entryAttributes());

        return $this->backToMonth($budgetEntry->budgetMonth)->with('success', 'Entry '.$budgetEntry->description.' updated');
    }

    public function destroy(BudgetEntry $budgetEntry): RedirectResponse
    {
        $budgetEntry->delete();

        return $this->backToMonth($budgetEntry->budgetMonth)->with('success', 'Entry deleted: '.$budgetEntry->description);
    }

    private function backToMonth(BudgetMonth $budgetMonth): RedirectResponse
    {
        return redirect()->route('budget.show', ['year' => $budgetMonth->month->year, 'month' => $budgetMonth->month->month]);
    }
}
