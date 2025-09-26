<?php
$title = 'testimonial';
$titles = 'testimonials';
$route = 'testimonials';
?>

<x-layout>
    <x-page-header title="testimonial" />

    <x-messages.errors title="Form validation failed:" />

    <section class="grid grid-cols-1 md:grid-cols-2 gap-6" aria-label="Testimonials">
        @foreach ($testimonials as $testimonial)
            <x-card title="testimonials" :item="$testimonial" route="testimonials" delMsg="Delete this testimonial?">
                <article class="space-y-4">
                    <!-- Profile Section -->
                    <header class="flex items-center space-x-5">
                        @if ($testimonial->image)
                            <img src="{{ $testimonial->image->url }}"
                                alt="Profile photo of {{ $testimonial->firstName }} {{ $testimonial->lastName }}"
                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-600">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center border-2 border-gray-500"
                                role="img_placeholder"
                                aria-label="Initials for {{ $testimonial->firstName }} {{ $testimonial->lastName }}">
                                <span class="text-gray-300 font-medium text-lg">
                                    {{ substr($testimonial->firstName, 0, 1) }}{{ substr($testimonial->lastName, 0, 1) }}
                                </span>
                            </div>
                        @endif

                        <h3 class="text-white font-semibold">
                            {{ $testimonial->firstName }} {{ $testimonial->lastName }}
                        </h3>
                    </header>

                    <!-- Testimonial Content -->
                    <blockquote class="text-gray-100 text-sm italic leading-relaxed">
                        "{{ Str::limit($testimonial->testimonial, 150) }}"
                    </blockquote>
                </article>
            </x-card>

            {{-- Edit form --}}
            <x-forms.edit :title="$title" :item="$testimonial" :route="$route">
                <fieldset class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <legend class="sr-only">Personal Information</legend>
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-300 mb-2">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter first name"
                            value="{{ $testimonial->firstName }}" required
                            class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-300 mb-2">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter last name"
                            value="{{ $testimonial->lastName }}" required
                            class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                    </div>
                </fieldset>
                <div class="mb-4">
                    <label for="testimonial" class="block text-sm font-medium text-gray-300 mb-2">Testimonial</label>
                    <textarea id="testimonial" name="testimonial" placeholder="Enter testimonial content" required rows="4"
                        class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">{{ $testimonial->testimonial }}</textarea>
                </div>
                <div class="mb-6">
                    <label for="image_id" class="block text-sm font-medium text-gray-300 mb-2">Profile Image</label>
                    <select id="image_id" name="image_id"
                        class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                        <option @if ($testimonial->image_id === null) selected @endif value="">No image</option>
                        @foreach ($images ?? [] as $image)
                            <option @if ($testimonial->image_id == $image->id) selected @endif value="{{ $image->id }}">
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
            </x-forms.edit>
        @endforeach
    </section>

    <x-forms.create title="testimonial" route="testimonials">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter title/position"
                value="{{ old('title') }}" required
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
        </div>
        <fieldset class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <legend class="sr-only">Personal Information</legend>
            <div>
                <label for="firstName" class="block text-sm font-medium text-gray-300 mb-2">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter first name"
                    value="{{ old('firstName') }}" required
                    class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
            </div>
            <div>

                <label for="lastName" class="block text-sm font-medium text-gray-300 mb-2">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter last name"
                    value="{{ old('lastName') }}" required
                    class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
            </div>
        </fieldset>

        <div class="mb-4">
            <label for="testimonial" class="block text-sm font-medium text-gray-300 mb-2">Testimonial</label>
            <textarea id="testimonial" name="testimonial" placeholder="Enter testimonial content" required rows="4"
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">{{ old('testimonial') }}</textarea>
        </div>
        <div class="mb-6">
            <label for="image_id" class="block text-sm font-medium text-gray-300 mb-2">Profile Image</label>
            <select id="image_id" name="image_id"
                class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
                <option selected disabled class="italic">Select an image (optional)</option>
                <option value="">No image</option>
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
