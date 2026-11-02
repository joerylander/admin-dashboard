@php
    $previous = $date->subMonth();
    $next = $date->addMonth();
    $navLink = 'text-gray-400 hover:text-white text-2xl px-2';
@endphp

<x-layout>
    <header class="mb-8 flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-2">
            <a href="{{ route('budget.show', ['year' => $previous->year, 'month' => $previous->month]) }}"
                class="{{ $navLink }}" aria-label="Previous month">&larr;</a>
            <h1 class="text-4xl font-bold text-white w-64 text-center">{{ $date->format('F Y') }}</h1>
            <a href="{{ route('budget.show', ['year' => $next->year, 'month' => $next->month]) }}"
                class="{{ $navLink }}" aria-label="Next month">&rarr;</a>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('budget.recurring.index') }}"
                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Recurring templates
            </a>
            @if ($budgetMonth)
                <button onclick="showCreateForm()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Add Entry
                </button>
            @endif
        </div>
    </header>

    <x-messages.errors />

    @if (! $budgetMonth)
        {{-- Month not started yet --}}
        <section class="bg-gray-800 border border-gray-600 rounded-lg p-8 text-center">
            <h2 class="text-xl font-semibold text-white mb-2">No budget for {{ $date->format('F Y') }} yet</h2>
            <p class="text-gray-400 mb-6">Start from your recurring templates, or copy every entry from last month.</p>
            <form method="POST" action="{{ route('budget.months.store') }}" class="flex justify-center gap-3">
                @csrf
                <input type="hidden" name="year" value="{{ $date->year }}">
                <input type="hidden" name="month" value="{{ $date->month }}">
                {{-- The clicked button's name/value is what gets sent as "source" --}}
                <button type="submit" name="source" value="templates"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Start from templates
                </button>
                @if ($previousMonthExists)
                    <button type="submit" name="source" value="previous"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                        Copy {{ $previous->format('F') }}
                    </button>
                @endif
            </form>
        </section>
    @else
        {{-- Summary --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <article class="bg-gray-800 border border-gray-600 rounded-lg p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Income</h2>
                <p class="text-3xl font-bold text-white">{{ $budgetMonth->currency->format($totals['income']) }}</p>
            </article>
            <article class="bg-gray-800 border border-gray-600 rounded-lg p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Costs</h2>
                <p class="text-3xl font-bold text-white">{{ $budgetMonth->currency->format($totals['costs']) }}</p>
                <p class="text-sm text-gray-400 mt-1">
                    Fixed {{ $budgetMonth->currency->format($totals['fixed_costs']) }}
                    &middot; Expenses {{ $budgetMonth->currency->format($totals['expenses']) }}
                </p>
            </article>
            <article @class([
                'rounded-lg p-6 border',
                'bg-green-950 border-green-700' => $totals['balance'] >= 0,
                'bg-red-950 border-red-700' => $totals['balance'] < 0,
            ])>
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Balance</h2>
                <p @class([
                    'text-3xl font-bold',
                    'text-green-400' => $totals['balance'] >= 0,
                    'text-red-400' => $totals['balance'] < 0,
                ])>{{ $budgetMonth->currency->format($totals['balance']) }}</p>
            </article>
        </section>

        {{-- One list per type --}}
        @foreach ($types as $type)
            @php
                $entries = $entriesByType->get($type->value, collect());
            @endphp
            <section class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-3">{{ $type->label() }}</h2>
                @if ($entries->isEmpty())
                    <p class="text-gray-500 text-sm">Nothing here yet.</p>
                @else
                    <table class="w-full text-left bg-gray-800 rounded-lg overflow-hidden">
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($entries as $entry)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-4 py-3 text-white">
                                        {{ $entry->description }}
                                        @if ($entry->recurring_entry_id)
                                            <span class="ml-2 text-xs text-blue-300 bg-blue-950 px-2 py-0.5 rounded">recurring</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-400">{{ $entry->category }}</td>
                                    <td class="px-4 py-3 text-white text-right whitespace-nowrap">{{ $entry->currency->format($entry->amount) }}</td>
                                    <td class="px-4 py-3 w-20">
                                        <div class="flex gap-2 items-center justify-end">
                                            <x-buttons.edit :id="$entry->id" />
                                            <x-forms.destroy :item="$entry" route="budget.entries" message="Delete this entry?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>
        @endforeach

        {{-- Modals --}}
        @foreach ($budgetMonth->entries as $entry)
            <x-forms.edit title="entry" :item="$entry" :action="route('budget.entries.update', $entry)" :titleField="false">
                <x-budget.entry-fields :types="$types" :entry="$entry" />
            </x-forms.edit>
        @endforeach

        <x-forms.create title="entry" :action="route('budget.entries.store', $budgetMonth)">
            <x-budget.entry-fields :types="$types" />
        </x-forms.create>

        <script>
            function showCreateForm() {
                const modal = document.getElementById('createForm');
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            }
        </script>
    @endif
</x-layout>
