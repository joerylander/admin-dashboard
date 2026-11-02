<?php

namespace App\Http\Controllers;

use App\Enums\Currency;
use App\Enums\EntryType;
use App\Http\Requests\RecurringEntryRequest;
use App\Models\RecurringEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecurringEntryController extends Controller
{
    public function index(): View
    {
        return view('budget.recurring.index', [
            'recurringEntries' => RecurringEntry::orderBy('type')->orderBy('category')->orderBy('description')->get(),
            'types' => EntryType::recurring(),
        ]);
    }

    public function store(RecurringEntryRequest $request): RedirectResponse
    {
        RecurringEntry::create([
            ...$request->entryAttributes(),
            'currency' => Currency::default(),
        ]);

        return redirect()->route('budget.recurring.index')->with('success', 'Template created');
    }

    /**
     * New values apply to months started from now on. Already started months keep
     * their values (your history stays correct) unless "also update the current month" is ticked.
     */
    public function update(RecurringEntryRequest $request, RecurringEntry $recurringEntry): RedirectResponse
    {
        $recurringEntry->update([
            ...$request->entryAttributes(),
            'is_active' => $request->boolean('is_active'), // An unticked checkbox isn't sent at all
        ]);

        if ($request->boolean('apply_to_current_month')) {
            $recurringEntry->budgetEntries()
                ->whereHas('budgetMonth', fn ($query) => $query->forMonth(now()))
                ->update($request->entryAttributes());
        }

        return redirect()->route('budget.recurring.index')->with('success', 'Template '.$recurringEntry->description.' updated');
    }

    /**
     * Entries already created from the template are kept; they just lose the link to it.
     */
    public function destroy(RecurringEntry $recurringEntry): RedirectResponse
    {
        $recurringEntry->delete();

        return redirect()->route('budget.recurring.index')->with('success', 'Template deleted: '.$recurringEntry->description);
    }
}
