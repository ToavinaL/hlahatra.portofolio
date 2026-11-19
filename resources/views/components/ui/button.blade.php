@props(['href' => null, 'variant' => 'primary'])

@php
    // Le texte du bouton rouge est noir : le blanc cassé sur #FF304F n'atteint pas le contraste AA (≈ 3:1),
    // le noir #111014 sur #FF304F le dépasse (≈ 5:1).
    $classes = 'cut inline-flex items-center justify-center gap-2 px-6 py-3 font-display text-lg font-bold tracking-wide transition-colors duration-150 motion-reduce:transition-none focus-visible:outline-2 focus-visible:-outline-offset-4 '
        .match ($variant) {
            'ghost' => 'bg-surface text-bone hover:text-accent focus-visible:outline-bone',
            default => 'bg-accent text-ink hover:bg-bone focus-visible:outline-ink',
        };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button'])->class($classes) }}>{{ $slot }}</button>
@endif
