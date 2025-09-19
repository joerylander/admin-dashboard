<x-layout>
    <x-page-header title="benefit" />

    <x-messages.errors title="Form validation failed:" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($benefits as $benefit)
            <x-card title="benefits" :item="$benefit" route="benefits" />
        @endforeach
    </div>

    <x-forms.create-form title="benefit" route="benefits" />

    @if ($benefits->isEmpty())
        <x-empty-placeholder title="benefits" />
    @endif

</x-layout>
