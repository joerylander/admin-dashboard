<x-layout>
    <h2>Currently available Ninjas</h2>

    <ul>
        @foreach ($ninjas as $ninja)
            <li>
                {{-- href="..." == attribute --}}
                {{-- :highlight == property --}}
                <x-card href="/ninjas/{{ $ninja['id'] }}" :highlight="$ninja['skill'] > 50">
                    <h3>
                        {{ $ninja['name'] }}
                    </h3>
                </x-card>
            </li>
        @endforeach
    </ul>
</x-layout>
