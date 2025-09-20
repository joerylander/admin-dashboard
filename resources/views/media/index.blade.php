<x-layout>
    <section class="grid grid-cols-2 gap-8">

        @foreach ($images as $image)
            <figure class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg aspect-[4/3] text-center">
                <!-- Image -->
                <img src="{{ $image->url }}" alt="{{ $image->original_filename }}"
                    class="w-full h-full object-center object-contain"> {{-- </div> --}}

                <!-- Image Info -->
                <div class="p-4">
                    <figcaption class="text-white font-medium">{{ $image->original_filename }}</figcaption>
                    <figcaption class="text-gray-400 text-sm">{{ $image->file_path }}</figcaption>
                </div>
            </figure>
        @endforeach

        @if ($images->isEmpty())
            <x-empty-placeholder title="images" />
        @endif
    </section>
</x-layout>
