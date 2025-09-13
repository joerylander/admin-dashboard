<x-layout>
    @foreach ($testimonials as $testimonial)
        <div class="">
            {{ $testimonial->firstName }}
            {{ $testimonial->lastName }}
            {{ $testimonial->title }}
            {{ $testimonial->testimonial }}
        </div>
        <br />
    @endforeach
</x-layout>
