<?php

use App\Enums\EntryType;
use App\Models\BudgetEntry;
use App\Models\BudgetMonth;
use App\Models\RecurringEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are sent to the login page', function () {
    $this->get(route('budget.show', ['year' => 2026, 'month' => 11]))->assertRedirect(route('show.login'));
});

describe('as a logged in user', function () {
    beforeEach(function () {
        $this->actingAs(User::factory()->create());
        $this->travelTo('2026-11-15');
    });

    test('the budget link opens the current month', function () {
        $this->get(route('budget.index'))->assertRedirect(route('budget.show', ['year' => 2026, 'month' => 11]));
    });

    test('a month that does not exist returns 404', function () {
        $this->get('/budget/2026/13')->assertNotFound();
    });

    test('a month that has not been started shows the start buttons', function () {
        $this->get(route('budget.show', ['year' => 2026, 'month' => 11]))
            ->assertOk()
            ->assertSee('Start from templates')
            ->assertDontSee('Copy October'); // No previous month to copy
    });

    test('starting a month from templates copies only active templates', function () {
        $salary = RecurringEntry::factory()->create(['type' => EntryType::Income, 'description' => 'Salary', 'amount' => 35_000_00]);
        RecurringEntry::factory()->inactive()->create(['description' => 'Old gym']);

        $this->post(route('budget.months.store'), ['year' => 2026, 'month' => 12, 'source' => 'templates'])
            ->assertRedirect(route('budget.show', ['year' => 2026, 'month' => 12]));

        $entry = BudgetMonth::sole()->entries()->sole();
        expect($entry->description)->toBe('Salary')
            ->and($entry->amount)->toBe(35_000_00)
            ->and($entry->recurring_entry_id)->toBe($salary->id);
    });

    test('copying the previous month copies every entry exactly, including expenses', function () {
        $october = BudgetMonth::factory()->create(['month' => '2026-10-01']);
        BudgetEntry::factory()->for($october)->create(['type' => EntryType::Expense, 'description' => 'Groceries', 'amount' => 4_321_50]);
        BudgetEntry::factory()->for($october)->create(['type' => EntryType::FixedCost, 'description' => 'Rent', 'amount' => 12_000_00]);

        $this->post(route('budget.months.store'), ['year' => 2026, 'month' => 11, 'source' => 'previous'])
            ->assertRedirect(route('budget.show', ['year' => 2026, 'month' => 11]));

        $november = BudgetMonth::forMonth(now())->sole();
        expect($november->entries()->orderBy('description')->pluck('amount', 'description')->all())
            ->toBe(['Groceries' => 4_321_50, 'Rent' => 12_000_00]);
    });

    test('copying fails when there is no previous month', function () {
        $this->post(route('budget.months.store'), ['year' => 2026, 'month' => 11, 'source' => 'previous'])
            ->assertSessionHasErrors(['source' => 'There is no previous month to copy.']);

        expect(BudgetMonth::count())->toBe(0);
    });

    test('a month cannot be started twice', function () {
        BudgetMonth::factory()->create(['month' => '2026-11-01']);

        $this->post(route('budget.months.store'), ['year' => 2026, 'month' => 11, 'source' => 'templates'])
            ->assertSessionHasErrors(['month' => 'This month has already been started.']);

        expect(BudgetMonth::count())->toBe(1);
    });

    test('the totals and a negative balance are calculated for the month', function () {
        $november = BudgetMonth::factory()->create(['month' => '2026-11-01']);
        BudgetEntry::factory()->for($november)->create(['type' => EntryType::Income, 'amount' => 10_000_00]);
        BudgetEntry::factory()->for($november)->create(['type' => EntryType::FixedCost, 'amount' => 8_000_00]);
        BudgetEntry::factory()->for($november)->create(['type' => EntryType::Expense, 'amount' => 2_500_50]);
        BudgetEntry::factory()->for($november)->create(['type' => EntryType::Expense, 'amount' => 499_50]);
        // Another month's entry must not be counted
        BudgetEntry::factory()->for(BudgetMonth::factory()->create(['month' => '2026-10-01']))->create(['type' => EntryType::Income]);

        $this->get(route('budget.show', ['year' => 2026, 'month' => 11]))
            ->assertOk()
            ->assertViewHas('totals', [
                'income' => 10_000_00,
                'fixed_costs' => 8_000_00,
                'expenses' => 3_000_00,
                'costs' => 11_000_00,
                'balance' => -1_000_00,
            ]);
    });

    test('an entry amount is stored in öre in the month\'s currency', function () {
        $november = BudgetMonth::factory()->create(['month' => '2026-11-01']);

        $this->post(route('budget.entries.store', $november), [
            'type' => 'expense',
            'category' => 'food',
            'description' => 'Groceries',
            'amount' => '1 250,5',
        ])->assertRedirect(route('budget.show', ['year' => 2026, 'month' => 11]));

        $entry = BudgetEntry::sole();
        expect($entry->amount)->toBe(1_250_50)
            ->and($entry->currency)->toBe($november->currency)
            ->and($entry->category)->toBe('Food');
    });

    test('an invalid amount is rejected', function (string $amount) {
        $november = BudgetMonth::factory()->create(['month' => '2026-11-01']);

        $this->post(route('budget.entries.store', $november), [
            'type' => 'expense',
            'category' => 'Food',
            'description' => 'Groceries',
            'amount' => $amount,
        ])->assertSessionHasErrors(['amount' => 'The amount must be a positive number with at most 2 decimals, e.g. 1 250,50.']);

        expect(BudgetEntry::count())->toBe(0);
    })->with([
        'negative' => '-100',
        'not a number' => 'abc',
        'three decimals' => '12,345',
    ]);

    test('an unknown entry type is rejected', function () {
        $november = BudgetMonth::factory()->create(['month' => '2026-11-01']);

        $this->post(route('budget.entries.store', $november), [
            'type' => 'savings',
            'category' => 'Food',
            'description' => 'Groceries',
            'amount' => '100',
        ])->assertSessionHasErrors('type');
    });

    test('editing a month\'s entry does not change its template', function () {
        $template = RecurringEntry::factory()->create(['amount' => 12_000_00]);
        $entry = BudgetEntry::factory()->for($template)->create(['amount' => 12_000_00]);

        $this->put(route('budget.entries.update', $entry), [
            'type' => $entry->type->value,
            'category' => $entry->category,
            'description' => $entry->description,
            'amount' => '13000',
        ])->assertSessionHasNoErrors();

        expect($entry->fresh()->amount)->toBe(13_000_00)
            ->and($template->fresh()->amount)->toBe(12_000_00);
    });

    test('an entry can be deleted', function () {
        $entry = BudgetEntry::factory()->create();

        $this->delete(route('budget.entries.destroy', $entry))->assertRedirect();

        $this->assertModelMissing($entry);
    });
});
