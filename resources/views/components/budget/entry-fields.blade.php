{{-- Fields shared by the create/edit forms for budget entries and recurring templates --}}
@props(['types', 'entry' => null])

@php
    $suffix = $entry?->id ?? 'new'; // Unique ids, since every edit modal is on the page at once
    $input = 'w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500';
@endphp

<div class="mb-4">
    <label for="type-{{ $suffix }}" class="block text-sm font-medium text-gray-300 mb-2">Type</label>
    <select id="type-{{ $suffix }}" name="type" required class="{{ $input }}">
        @foreach ($types as $type)
            <option value="{{ $type->value }}" @selected(($entry?->type->value ?? old('type')) === $type->value)>
                {{ $type->label() }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-4">
    <label for="category-{{ $suffix }}" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
    <input id="category-{{ $suffix }}" type="text" name="category" placeholder="e.g. Housing" required
        value="{{ $entry?->category ?? old('category') }}" class="{{ $input }}">
</div>
<div class="mb-4">
    <label for="description-{{ $suffix }}" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
    <input id="description-{{ $suffix }}" type="text" name="description" placeholder="e.g. Rent" required
        value="{{ $entry?->description ?? old('description') }}" class="{{ $input }}">
</div>
<div class="mb-6">
    <label for="amount-{{ $suffix }}" class="block text-sm font-medium text-gray-300 mb-2">Amount</label>
    <input id="amount-{{ $suffix }}" type="text" inputmode="decimal" name="amount" placeholder="e.g. 1 250,50" required
        value="{{ $entry ? $entry->currency->toInputValue($entry->amount) : old('amount') }}" class="{{ $input }}">
</div>
{{ $slot }}
