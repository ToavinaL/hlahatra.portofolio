@props(['title', 'level' => 2])

@php
    $level = min(max((int) $level, 1), 6);
@endphp

<div {{ $attributes->class('max-w-2xl') }}>
    <h{{ $level }} class="font-display text-4xl font-bold leading-none md:text-5xl">{{ $title }}</h{{ $level }}>

    @if ($slot->isNotEmpty())
        <p class="mt-4 text-lg leading-relaxed text-mist">{{ $slot }}</p>
    @endif
</div>
