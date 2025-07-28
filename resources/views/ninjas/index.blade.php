<x-layout>
    <h2>Currently available Ninjas</h2>

    <ul>
        @foreach ($ninjas as $ninja)
            <li>
                {{-- href="..." == attribute --}}
                {{-- :highlight == property --}}
                <x-card href="{{ route('ninjas.show', $ninja->id) }}" :highlight="$ninja['skill'] > 50">
                    <div class="">
                        <h3>
                            {{ $ninja->name }}
                        </h3>
                        <p>
                            {{ $ninja->dojo->name }}
                        </p>
                    </div>
                </x-card>
            </li>
        @endforeach
    </ul>

    {{ $ninjas->links() }}
</x-layout>
