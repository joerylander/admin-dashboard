@props(['title', 'item', 'route'])

<article
    class="bg-gray-800 border border-gray-400 rounded-lg p-6 hover:bg-gray-700 transition-colors duration-200 overflow-hidden">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-white break-words">{{ $item->title }}</h3>
        <div class="flex gap-2 items-center justify-center">
            <x-buttons.edit :id="$item->id" />
            <x-forms.destroy :item="$item" :route="'portfolio.' . $route" message="Delete this benefit?" />
        </div>
    </div>
    <p class="text-gray-300 text-sm break-words">{{ $item->description }}</p>
</article>

<x-forms.edit :title="$title" :item="$item" :route="$route" />
