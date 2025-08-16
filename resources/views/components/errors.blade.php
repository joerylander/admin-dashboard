@props(['title' => 'Please fix the following errors:'])

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 my-4 px-4 py-3 rounded mb-4">
        <strong>{{ $title }}</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li class="my-2">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
