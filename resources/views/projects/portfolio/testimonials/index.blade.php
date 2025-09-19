<x-layout>
    <x-page-header title="testimonial" />

    <x-messages.errors title="Form validation failed:" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($testimonials as $testimonial)
            <x-card title="testimonials" :item="$testimonial" route="testimonials" />
        @endforeach
    </div>

    <x-forms.create-form title="testimonial" route="testimonials" />

    @if ($testimonials->isEmpty())
        <x-empty-placeholder title="testimonials" />
    @endif

</x-layout>
