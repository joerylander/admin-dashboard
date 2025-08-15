<x-layout>
    <h2>This is your new Dashboard view</h2>

    <section>
        <h3>Benefits</h3>
        @foreach ($benefits as $benefit)
            <x-card :highlight=true>
                <div>
                    <h4>
                        {{ $benefit->title }}
                    </h4>
                    <p>
                        {{ $benefit->description }}
                    </p>
                </div>
            </x-card>
        @endforeach
    </section>
</x-layout>
