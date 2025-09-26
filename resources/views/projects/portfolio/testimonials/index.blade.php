<x-layout>
    <x-page-header title="testimonial" />

    <x-messages.errors title="Form validation failed:" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($testimonials as $testimonial)
            <x-card title="testimonials" :item="$testimonial" route="testimonials" delMsg="Delete this testimonial?" />
        @endforeach
    </div>

    <x-forms.create title="testimonial" route="testimonials">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">First Name</label>
                <input type="text" name="firstName" placeholder="Enter first name" value="{{ old('firstName') }}"
                    required
                    class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Last Name</label>
                <input type="text" name="lastName" placeholder="Enter last name" value="{{ old('lastName') }}"
                    required
                    class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
            <input type="text" name="title" placeholder="Enter title/position" value="{{ old('title') }}" required
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Testimonial</label>
            <textarea name="testimonial" placeholder="Enter testimonial content" required rows="4"
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">{{ old('testimonial') }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Profile Image</label>
            <select name="image_id"
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                <option value="">Select an image (optional)</option>
                @foreach ($images ?? [] as $image)
                    <option value="{{ $image->id }}" {{ old('image_id') == $image->id ? 'selected' : '' }}>
                        {{ $image->original_filename }}
                    </option>
                @endforeach
            </select>
            <p class="text-gray-400 text-sm mt-1">
                No images?
                <br>
                <a href="{{ route('media.index') }}" class="text-blue-400 hover:text-blue-300">
                    Upload some first →</a>
            </p>
        </div>
    </x-forms.create>


    @if ($testimonials->isEmpty())
        <x-empty-placeholder title="testimonials" />
    @endif

</x-layout>
