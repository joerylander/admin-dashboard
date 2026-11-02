<x-layout>
    <header class="mb-8 flex flex-wrap justify-between items-center gap-4">
        <div>
            <a href="{{ route('budget.index') }}" class="text-gray-400 hover:text-white text-sm">&larr; Back to budget</a>
            <h1 class="text-4xl font-bold text-white">Recurring templates</h1>
            <p class="text-gray-400 mt-1">Used as starting values when you start a month from templates.</p>
        </div>
        <button onclick="showCreateForm()"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Add Template
        </button>
    </header>

    <x-messages.errors />

    @if ($recurringEntries->isEmpty())
        <p class="text-gray-500">No templates yet. Add your salary, rent and other things that repeat every month.</p>
    @else
        <table class="w-full text-left bg-gray-800 rounded-lg overflow-hidden">
            <thead class="text-xs text-gray-400 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach ($recurringEntries as $template)
                    <tr @class(['hover:bg-gray-700', 'opacity-50' => ! $template->is_active])>
                        <td class="px-4 py-3 text-white">
                            {{ $template->description }}
                            @unless ($template->is_active)
                                <span class="ml-2 text-xs text-gray-300 bg-gray-700 px-2 py-0.5 rounded">paused</span>
                            @endunless
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $template->category }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $template->type->label() }}</td>
                        <td class="px-4 py-3 text-white text-right whitespace-nowrap">{{ $template->currency->format($template->amount) }}</td>
                        <td class="px-4 py-3 w-20">
                            <div class="flex gap-2 items-center justify-end">
                                <x-buttons.edit :id="$template->id" />
                                <x-forms.destroy :item="$template" route="budget.recurring"
                                    message="Delete this template? Months already started keep their entries." />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Modals --}}
    @foreach ($recurringEntries as $template)
        <x-forms.edit title="template" :item="$template" :action="route('budget.recurring.update', $template)" :titleField="false">
            <x-budget.entry-fields :types="$types" :entry="$template">
                {{-- value="1" so the 'boolean' rule accepts it (a checkbox sends "on" by default) --}}
                <label class="flex items-center gap-2 text-sm text-gray-300 mb-3">
                    <input type="checkbox" name="is_active" value="1" @checked($template->is_active)>
                    Active (used when starting new months)
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-300 mb-6">
                    <input type="checkbox" name="apply_to_current_month" value="1">
                    Also update {{ now()->format('F Y') }}
                </label>
            </x-budget.entry-fields>
        </x-forms.edit>
    @endforeach

    <x-forms.create title="template" :action="route('budget.recurring.store')">
        <x-budget.entry-fields :types="$types" />
    </x-forms.create>

    <script>
        function showCreateForm() {
            const modal = document.getElementById('createForm');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }
    </script>
</x-layout>
