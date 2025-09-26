<x-layout>
    <x-messages.errors title="Image upload failed" />
    <div class="mb-8 bg-gray-800 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4">Upload New Image</h2>
        <form method="POST" action="{{ route('media.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Select Image</label>
                    <input type="file" name="image" accept="image/*" multiple required
                        class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                    <select name="category" required
                        class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                        <option selected disabled>Select category</option>
                        <option value="general">General</option>
                        <option value="profiles">Profiles</option>
                        <option value="projects">Projects</option>
                    </select>
                </div>
            </div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                Upload Image
            </button>
        </form>
    </div>

    <section class="grid grid-cols-2 gap-8">
        @foreach ($images as $image)
            <figure class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg py-4 aspect-[4/3] text-center">
                <img src="{{ $image->url }}" alt="{{ $image->original_filename }}"
                    class="w-full h-full object-center object-contain">

                <div class="p-4">
                    <figcaption class="text-white font-medium ">
                        {{ $image->original_filename }}</figcaption>
                    <figcaption class="text-gray-400 text-sm truncate" title={{ $image->file_path }}>
                        {{ $image->file_path }}
                    </figcaption>
                </div>

                <x-forms.destroy :item="$image" route="media" message="Delete this image?" />
            </figure>
        @endforeach

        @if ($images->isEmpty())
            <x-empty-placeholder title="images" />
        @endif
    </section>
</x-layout>
