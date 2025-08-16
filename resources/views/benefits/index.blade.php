<x-layout>
    <h1>Benefits</h1>

    <x-errors title="Form validation failed:" />

    <!-- Create Button -->
    <button onclick="toggleCreateForm()" class="">Add New Benefit</button>

    <!-- Hidden Create Form -->
    <form method="POST" action="{{ route('benefits.store') }}" id="createForm" class="hidden">
        @csrf
        <input type="text" name="title" placeholder="Title" value="{{ old('title') }}" required>
        <textarea name="description" placeholder="Description" class="field-sizing-content" required>{{ old('description') }}</textarea>
        <button type="submit">Create</button>
        <button type="button" onclick="hideCreateForm()">Cancel</button>
    </form>

    <!-- Benefits List -->
    @foreach ($benefits as $benefit)
        <article class="flex">
            <div class="flex flex-col">

                <h3>{{ $benefit->title }}</h3>
                <p>{{ $benefit->description }}</p>
            </div>

            <div class="flex flex-col">
                <button onclick="showEditForm({{ $benefit->id }})">Edit</button>
                <!-- Hidden Edit Form for each benefit -->

                <form method="POST" action="{{ route('benefits.destroy', $benefit) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="confirm('Delete this benefit?')">Delete</button>
                </form>
            </div>
        </article>
        <form method="POST" action="{{ route('benefits.update', $benefit) }}" id="editForm{{ $benefit->id }}"
            class="hidden">
            @csrf
            @method('PUT')
            <input type="text" name="title" value="{{ $benefit->title }}" required>
            <textarea name="description" class="field-sizing-content" required>{{ $benefit->description }}</textarea>
            <button type="submit">Update</button>
            <button type="button" onclick="hideEditForm({{ $benefit->id }})">Cancel</button>
        </form>
    @endforeach

    <script>
        function toggleCreateForm() {
            const isHidden = document.getElementById('createForm').classList.contains('hidden');
            isHidden ? document.getElementById('createForm').classList.remove('hidden') : document.getElementById(
                'createForm').classList.add('hidden');
        }

        function hideCreateForm() {
            document.getElementById('createForm').classList.add('hidden');
        }

        function showEditForm(id) {
            document.getElementById(`editForm${id}`).classList.remove('hidden');
        }

        function hideEditForm(id) {
            document.getElementById(`editForm${id}`).classList.add('hidden');
        }
    </script>
</x-layout>
