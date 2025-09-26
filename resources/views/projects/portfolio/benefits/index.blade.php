<?php
$title = 'benefit';
$titles = 'benefits';
$route = 'benefits';
?>

<x-layout>
    <x-page-header :title="$title" />

    <x-messages.errors title="Form validation failed:" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($benefits as $benefit)
            <x-card :title="$titles" :item="$benefit" :route="$route" delMsg="Delete this benefit?">
                <p class="text-gray-300 text-sm break-words">{{ $benefit->description }}</p>
            </x-card>

            {{-- Edit form --}}
            <x-forms.edit :title="$title" :item="$benefit" :route="$route">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea name="description" required
                        class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 h-24">{{ $benefit->description }}</textarea>
                </div>
            </x-forms.edit>
        @endforeach
    </div>

    <x-forms.create :title="$title" :route="$route">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
            <input type="text" name="title" placeholder="Enter title" value="{{ old('title') }}" required
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
            <textarea name="description" placeholder="Enter description (minimum 20 characters)" required
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 h-24">{{ old('description') }}</textarea>
        </div>
    </x-forms.create>

    @if ($benefits->isEmpty())
        <x-empty-placeholder :title="$titles" />
    @endif
</x-layout>
