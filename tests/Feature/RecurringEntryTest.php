<?php

use App\Enums\EntryType;
use App\Models\BudgetEntry;
use App\Models\BudgetMonth;
use App\Models\RecurringEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->travelTo('2026-11-15');
});

test('the templates page renders', function () {
    RecurringEntry::factory()->create(['description' => 'Salary']);

    $this->get(route('budget.recurring.index'))->assertOk()->assertSee('Salary');
});

test('a template is created with its amount in öre', function () {
    $this->post(route('budget.recurring.store'), [
        'type' => 'income',
        'category' => 'Salary',
        'description' => 'Odevo',
        'amount' => '35 000',
    ])->assertRedirect(route('budget.recurring.index'));

    $template = RecurringEntry::sole();
    expect($template->amount)->toBe(35_000_00)
        ->and($template->is_active)->toBeTrue();
});

test('an expense cannot be a template', function () {
    $this->post(route('budget.recurring.store'), [
        'type' => 'expense',
        'category' => 'Food',
        'description' => 'Groceries',
        'amount' => '100',
    ])->assertSessionHasErrors('type');
});

/**
 * A salary template with an entry in last month and this month.
 *
 * @return array{0: RecurringEntry, 1: BudgetEntry, 2: BudgetEntry}
 */
function salaryWithTwoMonths(): array
{
    $template = RecurringEntry::factory()->create(['type' => EntryType::Income, 'amount' => 35_000_00]);
    $october = BudgetEntry::factory()->for($template)
        ->for(BudgetMonth::factory()->create(['month' => '2026-10-01']))
        ->create(['type' => EntryType::Income, 'amount' => 35_000_00]);
    $november = BudgetEntry::factory()->for($template)
        ->for(BudgetMonth::factory()->create(['month' => '2026-11-01']))
        ->create(['type' => EntryType::Income, 'amount' => 35_000_00]);

    return [$template, $october, $november];
}

function raiseSalary(RecurringEntry $template, array $extra = []): array
{
    return [
        'type' => 'income',
        'category' => $template->category,
        'description' => $template->description,
        'amount' => '37000',
        'is_active' => '1',
        ...$extra,
    ];
}

test('updating a template leaves started months unchanged by default', function () {
    [$template, $october, $november] = salaryWithTwoMonths();

    $this->put(route('budget.recurring.update', $template), raiseSalary($template))
        ->assertRedirect(route('budget.recurring.index'));

    expect($template->fresh()->amount)->toBe(37_000_00)
        ->and($october->fresh()->amount)->toBe(35_000_00)
        ->and($november->fresh()->amount)->toBe(35_000_00);
});

test('updating a template can also update the current month, but never earlier months', function () {
    [$template, $october, $november] = salaryWithTwoMonths();

    $this->put(route('budget.recurring.update', $template), raiseSalary($template, ['apply_to_current_month' => '1']))
        ->assertSessionHasNoErrors();

    expect($november->fresh()->amount)->toBe(37_000_00)
        ->and($october->fresh()->amount)->toBe(35_000_00);
});

test('unticking active pauses a template', function () {
    $template = RecurringEntry::factory()->create();

    $this->put(route('budget.recurring.update', $template), [
        'type' => $template->type->value,
        'category' => $template->category,
        'description' => $template->description,
        'amount' => '100',
    ])->assertSessionHasNoErrors();

    expect($template->fresh()->is_active)->toBeFalse();
});

test('deleting a template keeps the entries created from it', function () {
    $template = RecurringEntry::factory()->create();
    $entry = BudgetEntry::factory()->for($template)->create();

    $this->delete(route('budget.recurring.destroy', $template))->assertRedirect(route('budget.recurring.index'));

    $this->assertModelMissing($template);
    expect($entry->fresh()->recurring_entry_id)->toBeNull();
});
