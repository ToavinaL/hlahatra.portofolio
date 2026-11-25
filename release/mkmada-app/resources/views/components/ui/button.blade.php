@props(['href' => null, 'variant' => 'primary'])

@php
    // Le texte du bouton rouge est noir : le blanc cassé sur #FF304F n'atteint pas le contraste AA (≈ 3:1),
    // le noir #111014 sur #FF304F le dépasse (≈ 5:1).
    $classes = 'cut group relative inline-flex items-center justify-center gap-3 px-6 py-3 font-display text-lg font-bold tracking-wide transition-all duration-300 hover:-translate-y-1 motion-reduce:transition-none motion-reduce:hover:translate-y-0 focus-visible:outline-2 focus-visible:-outline-offset-4 '
        .match ($variant) {
            'ghost' => 'border border-white/10 bg-surface/70 text-bone hover:border-accent hover:text-accent focus-visible:outline-bone',
            default => 'bg-accent text-ink shadow-[0_0_2rem_rgb(255_48_79/0.18)] hover:bg-bone focus-visible:outline-ink',
        };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button'])->class($classes) }}>{{ $slot }}</button>
@endif
