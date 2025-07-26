@props(['highlight' => false])

<div @class(['class', 'highlight' => $highlight])>
    {{ $slot }}
    <a {{ $attributes }} class="btn">View details</a>
</div>
