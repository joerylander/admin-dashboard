<x-layout>
    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-4xl font-bold text-white">Benefits</h1>
        <button onclick="showCreateForm()"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Add New Benefit
        </button>
    </header>

    <x-errors title="Form validation failed:" />



    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($benefits as $benefit)
            <article
                class="bg-gray-800 border border-gray-700 rounded-lg p-6 hover:bg-gray-700 transition-colors duration-200 overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold text-white break-words">{{ $benefit->title }}</h3>
                    <div class="flex space-x-2 shrink-0">
                        <button onclick="showEditForm({{ $benefit->id }})" class="text-blue-400 hover:text-blue-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </button>

                        <form method="POST" action="{{ route('portfolio.benefits.destroy', $benefit) }}"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this benefit?')"
                                class="text-red-400 hover:text-red-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-gray-300 text-sm break-words">{{ $benefit->description }}</p>
            </article>

            <!-- Hidden Create Form -->
            <div id="createForm" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
                <article class="bg-gray-800 rounded-lg w-full max-w-lg p-8">
                    <h3 class="text-xl font-bold text-white mb-4">Create New Benefit</h3>
                    <form method="POST" action="{{ route('portfolio.benefits.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
                            <input type="text" name="title" placeholder="Enter benefit title"
                                value="{{ old('title') }}" required
                                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                            <textarea name="description" placeholder="Enter benefit description (minimum 20 characters)" required
                                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 h-24">{{ old('description') }}</textarea>
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                Create
                            </button>
                            <button type="button" onclick="hideCreateForm()"
                                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                Cancel
                            </button>
                        </div>
                    </form>
                </article>
            </div>

            <!-- Hidden Edit Form for each benefit -->
            <div id="editForm{{ $benefit->id }}"
                class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
                <article class="bg-gray-800 rounded-lg w-full max-w-lg p-8">
                    <h3 class="text-xl font-bold text-white mb-4">Edit Benefit</h3>
                    <form method="POST" action="{{ route('portfolio.benefits.update', $benefit) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
                            <input type="text" name="title" value="{{ $benefit->title }}" required
                                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                            <textarea name="description" required
                                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 h-24">{{ $benefit->description }}</textarea>
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                Update
                            </button>
                            <button type="button" onclick="hideEditForm({{ $benefit->id }})"
                                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                Cancel
                            </button>
                        </div>
                    </form>
                </article>
            </div>
        @endforeach
    </div>

    @if ($benefits->isEmpty())
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-400 mb-2">Benefits is currently empty</h3>
        </div>
    @endif

    <script>
        function showCreateForm() {
            const modal = document.getElementById('createForm');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function hideCreateForm() {
            const modal = document.getElementById('createForm');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        function showEditForm(id) {
            const modal = document.getElementById(`editForm${id}`);
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function hideEditForm(id) {
            const modal = document.getElementById(`editForm${id}`);
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('bg-black')) {
                event.target.classList.add('hidden');
                event.target.style.display = 'none';
            }
        });
    </script>
</x-layout>
