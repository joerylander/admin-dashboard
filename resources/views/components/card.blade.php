@props(['highlight' => false])

<article @class(['card', 'highlight' => $highlight])>
    {{ $slot }}
    <a {{ $attributes }} class="btn">View details</a>
</article>
