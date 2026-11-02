{{-- Paired together with edit button --}}
@props(['title', 'item', 'route' => null, 'action' => null, 'titleField' => true])

<div id="editForm{{ $item->id }}"
    data-modal-backdrop class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
    <article class="bg-gray-800 rounded-lg w-full max-w-lg p-8">
        <h3 class="text-xl font-bold text-white mb-4">Edit {{ ucfirst($title) }}</h3>
        <form method="POST" action="{{ $action ?? route('portfolio.' . $route . '.update', $item) }}">
            @csrf
            @method('PUT')
            @if ($titleField)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
                    <input type="text" name="title" value="{{ $item->title }}" required
                        class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                </div>
            @endif
            {{ $slot }}
            <div class="flex space-x-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Update
                </button>
                <button type="button" onclick="hideEditForm({{ $item->id }})"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </form>
    </article>
</div>

<script>
    function hideEditForm(id) {
        const modal = document.getElementById(`editForm${id}`);
        if (!modal) {
            console.error(`Element with id "editForm${id}" not found`);
            return;
        }
        modal.classList.add('hidden');
        modal.style.display = 'none';
    }
</script>
