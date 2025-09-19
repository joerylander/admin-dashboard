@props(['title', 'item', 'route'])

<article
    class="bg-gray-800 border border-gray-400 rounded-lg p-6 hover:bg-gray-700 transition-colors duration-200 overflow-hidden">
    <div class="flex justify-between items-start mb-4">
        <h3 class="text-lg font-semibold text-white break-words">{{ $item->title }}</h3>
        <div class="flex space-x-2 shrink-0">
            <button onclick="showEditForm({{ $item->id }})" class="text-blue-400 hover:text-blue-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </button>

            <x-forms.destroy :item="$item" :route="$route" />
        </div>
    </div>
    <p class="text-gray-300 text-sm break-words">{{ $item->description }}</p>
</article>

<x-forms.edit-form :title="$title" :item="$item" :route="$route" />
